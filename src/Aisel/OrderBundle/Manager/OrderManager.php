<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Manager;

use LogicException;
use Aisel\FrontendUserBundle\Entity\FrontendUser;
use Payum\Core\Request\Capture;
use Aisel\OrderBundle\Entity\Order;
use Aisel\CartBundle\Manager\CartManager;
use Aisel\ConfigBundle\Manager\ConfigManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Manager for Orders, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderManager
{
    /**
     * @var ContainerInterface
     */
    protected $sc;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var CartManager
     */
    protected $cartManager;

    /**
     * Constructor
     *
     * @param ContainerInterface $serviceContainer
     * @param EntityManager      $entityManager
     * @param ConfigManager      $configManager
     * @param CartManager        $cartManager
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        EntityManager $entityManager,
        ConfigManager $configManager,
        CartManager $cartManager
    ) {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
        $this->settingsManager = $configManager;
        $this->cartManager = $cartManager;
    }

    /**
     * Currency code from the system settings
     *
     * @param string $locale
     *
     * @return string $currency
     */
    private function getCurrencyCode($locale)
    {
        $config = $this
            ->settingsManager
            ->getConfigForEntity($locale, 'general');

        return $config['currency'];
    }

    /**
     * Get single order by given userId and orderId
     *
     * @param FrontendUser $user
     * @param int          $orderId
     *
     * @return Order $orderDetails
     */
    public function getUserOrder(FrontendUser $user, $orderId)
    {
        $order = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->findOrderForUser($user, $orderId);

        return $order;
    }

    /**
     * Get all order for user
     *
     * @param FrontendUser $user
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function getUserOrders(FrontendUser $user)
    {
        if (!($user)) throw new LogicException('User object is missing');

        $orders = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->findAllOrdersForUser($user);

        return $orders;
    }

    /**
     * Create order for given userId
     *
     * @param FrontendUser $user
     * @param mixed        $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $order
     */
    public function createOrderFromCart(FrontendUser $user, $orderInfo)
    {
        if (!($user)) {
            throw new LogicException('User object is missing');
        }

        if (count($user->getCart()) == 0) {
            throw new LogicException('User cart is empty');
        };
        $order = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromCartForUser(
                $user,
                $this->getCurrencyCode($orderInfo['locale']),
                $orderInfo
            );
        $token = $this->sc->get('payum.security.token_factory')->createCaptureToken(
            $orderInfo['payment_method'],
            $order,
            'aisel_payum_order'
        );
        $token->getTargetUrl();

//        $payment = $this->sc->get('payum')->getPayment('offline');
//        $payment->execute(new Capture($order));
        return $order;
    }

    /**
     * Create order for user
     *
     * @param FrontendUser $user
     * @param array        $products
     * @param mixed        $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function createOrderFromProducts($user, $products, $orderInfo)
    {
        if (!($user)) {
            throw new LogicException('User object is missing');
        }
        $currencyCode = $this->getCurrencyCode($orderInfo['locale']);

        $order = $this
            ->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromProductsForUser(
                $user,
                $products,
                $currencyCode,
                $orderInfo
            );

        return $order;
    }
}

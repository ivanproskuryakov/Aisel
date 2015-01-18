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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Request\Capture;

/**
 * Manager for Orders, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderManager
{
    protected $sc;
    protected $em;
    protected $settingsManager;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer,
                                $entityManager,
                                $settingsManager)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
        $this->settingsManager = $settingsManager;
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
            ->getConfigForEntity($locale, 'config_general');

        return $config['currency'];
    }

    /**
     * Get single order by given userId and orderId
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param int $orderId
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function getUserOrder($user, $orderId)
    {
        $order = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->findOrderForUser($user, $orderId);

        return $order;
    }

    /**
     * Get all order for user
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     *
     * @throws NotFoundHttpException
     */
    public function getUserOrders($user)
    {
        if (!($user)) throw new NotFoundHttpException('User object is missing');

        $orders = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->findAllOrdersForUser($user);

        return $orders;
    }

    /**
     * Create order for given userId
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string $locale
     * @param string $paymentName
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     *
     * @throws NotFoundHttpException
     */
    public function createOrderFromCart($user, $locale, $paymentName)
    {
        if (!($user)) throw new NotFoundHttpException('User object is missing');
        $order = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromCartForUser(
                $user,
                $locale,
                $this->getCurrencyCode($locale)
            );
        $token = $this->sc->get('payum.security.token_factory')->createCaptureToken(
            $paymentName,
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
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param string $locale
     * @param array $products
     * @param array $paymentName
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     *
     * @throws NotFoundHttpException
     */
    public function createOrderFromProducts($user, $locale, $products, $paymentName)
    {
        if (!($user)) throw new NotFoundHttpException('User object is missing');

        $order = $this
            ->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromProductsForUser(
                $user,
                $locale,
                $products,
                $this->getCurrencyCode($locale)
            );
        return $order;
    }

}

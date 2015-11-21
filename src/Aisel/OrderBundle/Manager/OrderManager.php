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
use Aisel\OrderBundle\Entity\Order;
use Aisel\CartBundle\Manager\CartManager;
use Aisel\ConfigBundle\Manager\ConfigManager;
use Doctrine\ORM\EntityManager;

/**
 * OrderManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class OrderManager
{

    /**
     * @var EntityManager
     */
    protected $dm;

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
     * @param EntityManager $EntityManager
     * @param ConfigManager $configManager
     * @param CartManager   $cartManager
     */
    public function __construct(
        EntityManager $EntityManager,
        ConfigManager $configManager,
        CartManager $cartManager
    ) {
        $this->dm = $EntityManager;
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
     * @param int $userId
     * @param int $orderId
     *
     * @return Order $orderDetails
     */
    public function getUserOrder($userId, $orderId)
    {
        $order = $this->dm
            ->getRepository('AiselOrderBundle:Order')
            ->findOrderForUser($userId, $orderId);

        return $order;
    }

    /**
     * Get all order for the user id
     *
     * @param int $userId
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function getUserOrders($userId)
    {
        if (!$userId) {
            throw new LogicException('User Id is missing');
        }

        $orders = $this->dm
            ->getRepository('AiselOrderBundle:Order')
            ->findAllOrdersForUser($userId);

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

        $order = $this->dm
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromCartForUser(
                $user,
                $this->getCurrencyCode($orderInfo['locale']),
                $orderInfo
            );

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
            ->dm
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

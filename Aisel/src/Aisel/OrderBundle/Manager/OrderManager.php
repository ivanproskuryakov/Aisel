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

use Aisel\CartBundle\Manager\CartManager;
use Aisel\ConfigBundle\Manager\ConfigManager;
use Aisel\OrderBundle\Entity\Order;
use Aisel\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use LogicException;

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
     * @param EntityManager $entityManager
     * @param ConfigManager $configManager
     * @param CartManager $cartManager
     */
    public function __construct(
        EntityManager $entityManager,
        ConfigManager $configManager,
        CartManager $cartManager
    )
    {
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
     * @param int $userId
     * @param int $orderId
     *
     * @return Order $orderDetails
     */
    public function getUserOrder($userId, $orderId)
    {
        $order = $this->em
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

        $orders = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->findAllOrdersForUser($userId);

        return $orders;
    }

    /**
     * Create order for given userId
     *
     * @param User $user
     * @param User $seller
     * @param mixed $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $order
     */
    public function createOrderFromCart(
        User $user,
        User $seller,
        array $orderInfo
    )
    {
        if (count($user->getCart()) == 0) {
            throw new LogicException('User cart is empty');
        };

        $order = $this->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromCartForUser(
                $user,
                $seller,
                $this->getCurrencyCode($orderInfo['locale']),
                $orderInfo
            );

        return $order;
    }

    /**
     * Create order for user
     *
     * @param User $user
     * @param User $seller
     * @param array $products
     * @param array $orderInfo
     *
     * @throws LogicException
     *
     * @return Order $orderDetails
     */
    public function createOrderFromProducts(
        User $user,
        User $seller,
        array $products,
        array $orderInfo
    )
    {
        $currencyCode = $this->getCurrencyCode($orderInfo['locale']);

        $order = $this
            ->em
            ->getRepository('AiselOrderBundle:Order')
            ->createOrderFromProductsForUser(
                $user,
                $seller,
                $products,
                $currencyCode,
                $orderInfo
            );

        return $order;
    }
}

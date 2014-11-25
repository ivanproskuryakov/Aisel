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

/**
 * Manager for Orders, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderManager
{
    protected $sc;
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer, $entityManager)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
    }

    /**
     * Get single order by given userId and orderId
     *
     * @param int $userId
     * @param int $orderId
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function getUserOrder($userId, $orderId)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->findOrderForUser($orderId, $userId);
        return $order;
    }

    /**
     * Get all order for user
     *
     * @param int $userId
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function getUserOrders($userId)
    {
        $orders = $this->em->getRepository('AiselOrderBundle:Order')->findAllOrdersForUser($userId);
        return $orders;
    }

    /**
     * Create order for given userId
     *
     * @param int $userId
     * @param string $locale
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function createOrder($userId, $locale)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->createOrderForUser($userId, $locale);
        return $order;
    }

}

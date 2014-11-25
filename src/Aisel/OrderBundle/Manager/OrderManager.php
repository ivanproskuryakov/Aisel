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
    protected $userManager;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer, $entityManager, $frontendUserManager)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
        $this->userManager = $frontendUserManager;
    }

    /**
     * User manager
     */
    private function getUserManager()
    {
        return $this->userManager;
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
        $user = $this->getUserManager()->loadById($userId);
        $order = $this->em->getRepository('AiselOrderBundle:Order')->findOrderForUser($orderId, $user);
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
        $user = $this->getUserManager()->loadById($userId);
        $orders = $this->em->getRepository('AiselOrderBundle:Order')->findAllOrdersForUser($user);
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
        $user = $this->getUserManager()->loadById($userId);
        $order = $this->em->getRepository('AiselOrderBundle:Order')->createOrderForUser($user, $locale);
        return $order;
    }

}

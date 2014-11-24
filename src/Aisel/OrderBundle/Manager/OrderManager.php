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
     *
     * @throws NotFoundHttpException*
     */
    public function getUserOrder($userId, $orderId)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->findOrderForUser($orderId, $userId);

        if (!($order)) {
            throw new NotFoundHttpException('Nothing found');
        }
        return $order;
    }

    /**
     * Get all order for user
     *
     * @param int $userId
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     *
     * @throws NotFoundHttpException*
     */
    public function getUserOrders($userId)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->findAllOrdersForUser($userId);

        if (!($order)) {
            throw new NotFoundHttpException('Nothing found');
        }
        return $order;
    }

    /**
     * Create order for given userId
     *
     * @param int $userId
     *
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     *
     * @throws NotFoundHttpException*
     */
    public function createOrder($userId)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->createOrderForUser($userId);

        if (!($order)) {
            throw new NotFoundHttpException('Nothing found');
        }
        return $order;
    }

}

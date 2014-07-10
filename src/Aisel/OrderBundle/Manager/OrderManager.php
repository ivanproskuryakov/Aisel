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
use Aisel\AdminBundle\Utility\UrlUtility;

/**
 * Manager for Orders, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get categories in array for order
     * @param  int $order
     * @return array $categories
     */
    public function getOrderCategories($order)
    {
        $categories = array();
        foreach ($order->getCategories() as $c) {
            $category = array();
            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $categories[$c->getId()] = $category;
        }

        return $categories;
    }

    /**
     * Get list of all orders
     * @param  array $params
     * @return array
     */
    public function getOrders($params)
    {
        $total = $this->em->getRepository('AiselOrderBundle:Order')->getTotalFromRequest($params);
        $orders = $this->em->getRepository('AiselOrderBundle:Order')->getCurrentOrdersFromRequest($params);

        $return = array(
            'total' => $total,
            'orders' => $orders
        );

        return $return;
    }

    /**
     * Get single detailed order with category by ID
     * @param  int $id
     * @return \Aisel\OrderBundle\Entity\Order $orderDetails
     */
    public function getOrder($id)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->find($id);

        if (!($order)) {
            throw new NotFoundHttpException('Nothing found');
        }

        $orderDetails = array('order' => $order, 'categories' => $this->getOrderCategories($order));

        return $orderDetails;
    }

    /**
     * Get single detailed order with category by URLKey
     * @param  string $urlKey
     * @return \Aisel\OrderBundle\Entity\Order $order
     */
    public function getOrderByURL($urlKey)
    {

        $order = $this->em->getRepository('AiselOrderBundle:Order')->findOneBy(array('metaUrl' => $urlKey));

        if (!($order)) {
            throw new NotFoundHttpException('Nothing found');
        }

        $orderDetails = array('order' => $order, 'categories' => $this->getOrderCategories($order));

        return $orderDetails;
    }

    /**
     * validate metaUrl for Order Entity and return one we can use
     * @param  string $url
     * @param  int $orderId
     * @return string $validUrl
     */
    public function normalizeOrderUrl($url, $orderId = null)
    {
        $order = $this->em->getRepository('AiselOrderBundle:Order')->findTotalByURL($url, $orderId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);
        if ($order) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

    /**
     * Get List of all orders, except disabled
     * @return string
     */
    public function getEnabledOrders()
    {
        $orderList = $this->em->getRepository('AiselOrderBundle:Order')->getEnabledOrders();

        return $orderList;
    }

}

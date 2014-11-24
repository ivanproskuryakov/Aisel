<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend REST API for Order entities
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiOrderController extends Controller
{

    /**
     * Cart manager
     */
    private function getOrderManager()
    {
        return $this->get('aisel.order.manager');
    }

    /**
     * User manager
     */
    private function getUserManager()
    {
        return $this->get('frontend.user.manager');
    }

    /**
     * @Rest\View
     * /%website_api%/order/list.json
     */
    public function orderListAction()
    {
        $userId = $this->getUserManager()->getUserId();
        $orders = $this->getOrderManager()->getUserOrders($userId);

        // TODO: finish with order list
        $orders = false;
        return $orders;
    }

    /**
     * @Rest\View
     * /%website_api%/order/view/{id}.json
     */
    public function orderViewByIdAction($id)
    {
        $userId = $this->getUserManager()->getUserId();
        $order = $this->getOrderManager()->getUserOrder($userId, $id);

        // TODO: finish with order view
        $order = false;
        return $order;
    }

    /**
     * @Rest\View
     * /%website_api%/order/submit.json
     */
    public function orderSubmitAction()
    {
        $userId = $this->getUserManager()->getUserId();
        $order = $this->getOrderManager()->createOrder($userId);

        // TODO: finish with order view
        $order = false;
        return $order;
    }

}

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
     * /%website_api%/order/list.json
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderListAction()
    {
        $user = $this->getUserManager()->getUser();
        $orders = $this->getOrderManager()->getUserOrders($user);
        return $orders;
    }

    /**
     * /%website_api%/order/view/{id}.json
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderViewByIdAction($id)
    {
        $user = $this->getUserManager()->getUser();
        $order = $this->getOrderManager()->getUserOrder($user, $id);
        return $order;
    }

    /**
     * /%website_api%/order/submit.json
     *
     * @param string $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderSubmitAction($locale)
    {
        $user = $this->getUserManager()->getUser();
        $order = $this->getOrderManager()->createOrderFromCart($user, $locale);

        if ($order) {
            $response = array('status' => true, 'order' => $order, 'message' => 'Your order received, thank you!');
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during the order submit');
        }
        return $response;
    }

}

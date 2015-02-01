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
     * /%website_api%/orders.json
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderListAction()
    {
        $user = $this->getUserManager()->getUser();

        if (!$user) {
            return array(
                'status' => false,
                'message' => 'User object is missing'
            );
        }

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

        if (!$user) {
            return array(
                'status' => false,
                'message' => 'User object is missing'
            );
        }

        $order = $this->getOrderManager()->getUserOrder($user, $id);

        return $order;
    }

    /**
     * /%website_api%/order/submit.json
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderSubmitAction(Request $request, $locale)
    {
        $user = $this->getUserManager()->getUser();
        $orderInfo = array(
            'payment_method' => $request->get('payment_method'),
            'billing_country' => $request->get('billing_country'),
            'billing_region' => $request->get('billing_region'),
            'billing_city' => $request->get('billing_city'),
            'billing_phone' => $request->get('billing_phone'),
            'billing_comment' => $request->get('billing_comment'),
            'locale' => $locale,
        );
        $order = $this->getOrderManager()->createOrderFromCart($user, $orderInfo);

        $response = array(
            'status' => false,
            'message' => 'Something went wrong during order submit'
        );

        if ($order) {
            $response = array(
                'status' => true,
                'orderId' => $order->getId(),
                'message' => 'Your order received, thank you!'
            );
        };

        return $response;
    }

}

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

use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;
use Aisel\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiOrderController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiOrderController extends BaseApiController
{

    /**
     * getOrderManager
     */
    private function getOrderManager()
    {
        return $this->get('aisel.order.manager');
    }

//    /**
//     * User manager
//     *
//     * @return User
//     */
//    private function getUser()
//    {
//        return $this
//            ->get('aisel.user.manager')
//            ->getUser();
//    }

    /**
     * getOrderCollection
     */
    public function getOrderCollectionAction()
    {
        $user = $this->getUser();
        $orders = $this
            ->getOrderManager()
            ->getUserOrders($user->getId());

        return array_values($this->filterMaxDepth($orders));
    }

    /**
     * orderViewByIdAction
     *
     * @param int $orderId
     *
     * @return mixed
     */
    public function getOrderAction($orderId)
    {
        $user = $this->getUser();
        $order = $this
            ->getOrderManager()
            ->getUserOrder($user->getId(), $orderId);

        return $this->filterMaxDepth($order);

    }

    /**
     * orderSubmitAction
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return mixed
     */
    public function orderSubmitAction(Request $request, $locale)
    {
        $user = $this->getUser();
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

        if ($order) {
            $response = array(
                'status' => true,
                'orderId' => $order->getId(),
                'message' => 'Your order received, thank you!'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Something went wrong during order submit'
            );
        }

        return $response;
    }

}

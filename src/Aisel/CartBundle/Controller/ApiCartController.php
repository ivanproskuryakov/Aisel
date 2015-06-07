<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Frontend API controller to for Cart CRUD
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCartController extends Controller
{

    /**
     * cartAction
     */
    public function cartAction()
    {
        $user = $this
            ->get('frontend.user.manager')
            ->getUser();
        $cart = $this
            ->get('aisel.cart.manager')
            ->getUserCart($user);

        return $cart;
    }

    /**
     * cartProductUpdateAction
     *
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     */
    public function productQtyUpdateAction($productId, $qty)
    {
        $user = $this
            ->get('frontend.user.manager')
            ->getUser();

        $cartItem = $this
            ->get('aisel.cart.manager')
            ->updateProductInCart($user, $productId, $qty);

        if ($cartItem) {
            $response =
                array('status' => true,
                    'message' => 'Cart updated',
                    'cartItem' => $cartItem);
        } else {
            $response = array(
                'status' => false,
                'message' => 'Something went wrong during removing product from cart'
            );
        }

        return $response;
    }

    /**
     * cartProductUpdateAction
     *
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     */
    public function productAddAction($productId, $qty)
    {
        $user = $this
            ->get('frontend.user.manager')
            ->getUser();

        $cartItem = $this
            ->get('aisel.cart.manager')
            ->addProductToCart($user, $productId, $qty);

        return array(
                'status' => true,
                'message' => 'Product was added',
                'cartItem' => $cartItem
            );
    }

}

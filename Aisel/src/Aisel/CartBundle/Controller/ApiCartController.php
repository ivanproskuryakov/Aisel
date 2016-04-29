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

use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;

/**
 * Frontend API controller to for Cart CRUD
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiCartController extends BaseApiController
{

    /**
     * cartAction
     */
    public function cartAction()
    {
        $cart = $this
            ->get('aisel.cart.manager')
            ->getUserCart($this->getUser());

        return $this->filterMaxDepth($cart);
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
        $cartItem = $this
            ->get('aisel.cart.manager')
            ->updateProductInCart(
                $this->getUser(),
                $productId,
                $qty
            );

        if ($cartItem) {
            $response =
                array('status' => true,
                    'message' => 'Cart updated',
                    'cartItem' => $cartItem);
        } else {
            $response = array(
                'status' => false,
                'message' => 'Something went wrong with remove from cart operation'
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
        $cartItem = $this
            ->get('aisel.cart.manager')
            ->addProductToCart(
                $this->getUser(),
                $productId,
                $qty
            );

        return array(
            'status' => true,
            'message' => 'Product was added',
            'cartItem' => $cartItem
        );
    }

}

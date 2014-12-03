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

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend API controller to for Cart CRUD
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCartController extends Controller
{

    /**
     * Cart manager
     */
    private function getCartManager()
    {
        return $this->get('aisel.cart.manager');
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
     * /%website_api%/cart.json
     */
    public function cartAction()
    {
        return $this->getCartManager()->getUserCart();
    }

    /**
     * @Rest\View
     * /%website_api%/cart/product/{productId}/qty/{qty}/add.json
     */
    public function cartProductAddAction($productId, $qty)
    {
        $user = $this->getUserManager()->getUser();
        $cartItem = $this->getCartManager()->addProductToCart($user, $productId, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'message' => 'Product added to cart', 'cartItem' => $cartItem);
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during adding to cart');
        }
        return $response;
    }

    /**
     * @Rest\View
     * /%website_api%/cart/product/{productId}/qty/{qty}/update.json
     */
    public function cartProductUpdateAction($productId, $qty)
    {
        $user = $this->getUserManager()->getUser();
        $cartItem = $this->getCartManager()->updateProductInCart($user, $productId, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'message' => 'Cart updated', 'cartItem' => $cartItem);
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during removing from the cart');
        }
        return $response;
    }

}

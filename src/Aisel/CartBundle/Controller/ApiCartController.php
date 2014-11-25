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
        $userId = $this->getUserManager()->getUserId();
        return $this->getCartManager()->getUserCart($userId);
    }

    /**
     * @Rest\View
     * /%website_api%/cart/product/{productId}/qty/{qty}/add.json
     */
    public function cartProductAddAction($productId, $qty)
    {
        $userId = $this->getUserManager()->getUserId();
        $cartItem = $this->getCartManager()->addProductToCart($userId, $productId, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'cartItem' => $cartItem);
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
        $userId = $this->getUserManager()->getUserId();
        $cartItem = $this->getCartManager()->updateProductInCart($userId, $productId, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'cartItem' => $cartItem);
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during removing from the cart');
        }
        return $response;
    }

}

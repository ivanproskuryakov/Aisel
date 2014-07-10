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
 * Frontend Cart REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    private function isAuthenticated()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user !== 'anon.') {
            if (in_array('ROLE_USER', $user->getRoles())) return true;
        }

        return false;
    }

    /**
     * @Rest\View
     * /api/cart/list.json?limit=2&current=3
     */
    public function cartListAction(Request $request)
    {

        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category')
        );

        if ($request->get('user') && $this->isAuthenticated()) {
            $userid = $this->get('security.context')->getToken()->getUser()->getId();
            $params['userid'] = $userid;
        }

        $cartList = $this->container->get("aisel.cart.manager")->getCarts($params);

        return $cartList;

    }

    /**
     * @Rest\View
     */
    public function cartViewByURLAction($urlKey)
    {
        /** @var \Aisel\CartBundle\Entity\Cart $cart */
        $cart = $this->container->get("aisel.cart.manager")->getCartByURL($urlKey);

        return $cart;
    }
}

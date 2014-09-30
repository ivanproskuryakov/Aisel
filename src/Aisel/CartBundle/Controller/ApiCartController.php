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
 * Frontend Addressing Cities REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCartController extends Controller
{

    /**
     * @Rest\View
     * /%website_api%/cart.json
     */
    public function cartDetailsAction(Request $request)
    {
        $cart = false;
        return $cart;
    }

}

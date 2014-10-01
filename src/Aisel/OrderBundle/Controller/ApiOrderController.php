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
 * Frontend Addressing Cities REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiOrderController extends Controller
{

    /**
     * @Rest\View
     * /%website_api%/order/list.json
     */
    public function orderListAction(Request $request)
    {
        $order = false;
        return $order;
    }

    /**
     * @Rest\View
     * /%website_api%/order/view/{id}.json
     */
    public function orderViewByIdAction(Request $request)
    {
        $order = false;
        return $order;
    }

}

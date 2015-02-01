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

/**
 * Controller to handle Payum order capture
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PayumController extends Controller
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function orderAction()
    {
        return null;
    }
}

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
 * ApiCheckoutController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiCheckoutController extends Controller
{

    /**
     * initAction
     *
     * @param Request $request
     *
     * @return array
     */
    public function initAction(Request $request)
    {
        $configGeneral = $this
            ->container
            ->get("aisel.config.manager")
            ->getConfigForEntity($request->getLocale(),'general');

        $paymentMethods = $configGeneral['paymentMethods'];
        $checkout = array();
        $configMethods = $this->container->getParameter('aisel_order.payment_methods');

        foreach ($paymentMethods as $k => $m) {
            if (isset($configMethods[$m])) {
                $checkout['payment']['methods'][$m] = $configMethods[$m];
            }
        }

        return $checkout;
    }

}

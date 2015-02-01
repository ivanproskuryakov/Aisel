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
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Frontend REST API for Order entities
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCheckoutController extends Controller
{

    /**
     * /%website_api%/{locale}/order/checkout/init.json
     *
     * @return JsonResponse $response
     */
    public function initAction()
    {
        $response = array();

        /**
         * Payment methods
         */
        $config = $this->container->get("aisel.settings.manager")->getConfig('en');
        $general = (array) json_decode($config['config_general']);

        foreach ($general['paymentMethods'] as $m) {
            if ($method = $this->container->getParameter('aisel_order.payment_methods')[$m]) {
                $response['payment']['methods'][$m] = $method;
            }
        }

        return $response;
    }

}

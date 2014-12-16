<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Addressing Cities REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCityController extends Controller
{

    /**
     * /%website_api%/addressing/city/list.json
     */
    public function cityListAction(Request $request)
    {
        // TODO: finish addressing API functionality
        $cityList = true;
        return $cityList;
    }

    /**
     * /%website_api%/addressing/city/{id}.json
     */
    public function cityDetailsAction($id)
    {
        // TODO: finish addressing API functionality
        $cityDetails = $id;
        return $cityDetails;
    }
}

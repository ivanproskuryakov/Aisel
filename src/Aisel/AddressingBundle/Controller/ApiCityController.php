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

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Frontend Addressing REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCityController extends Controller
{

    /**
     * @Rest\View
     * /%website_api%/addressing/city/list.json
     */
    public function cityListAction(Request $request)
    {
        $cityList = true;
        return $cityList;
    }

    /**
     * /%website_api%/addressing/city/{id}.json
     */
    public function cityDetailsAction($id)
    {
        $cityDetails = $id;
        return $cityDetails;
    }
}

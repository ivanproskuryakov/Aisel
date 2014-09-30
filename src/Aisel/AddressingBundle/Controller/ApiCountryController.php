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
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Addressing Countries REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCountryController extends Controller
{

    /**
     * @Rest\View
     * /%website_api%/addressing/country/list.json
     */
    public function countryListAction(Request $request)
    {
        $countryList = true;
        return $countryList;
    }

    /**
     * /%website_api%/addressing/country/{id}.json
     */
    public function countryDetailsAction($id)
    {
        $countryDetails = $id;
        return $countryDetails;
    }
}

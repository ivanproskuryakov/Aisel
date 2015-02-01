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

/**
 * Frontend Addressing Countries REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCountryController extends Controller
{

    /**
     * Addressing manager
     */
    private function getAddressingManager()
    {
        return $this->get('aisel.addressing.manager');
    }

    /**
     * /%website_api%/addressing/country/list.json
     *
     * @return JsonResponse $response
     */
    public function countryListAction()
    {
        $countryList = $this->getAddressingManager()->getCountries();

        return $countryList;
    }

    /**
     * /%website_api%/addressing/country/{id}.json
     *
     * @param integer $id
     *
     * @return JsonResponse $response
     */
    public function countryDetailsAction($id)
    {
        $countryDetails = $this->getAddressingManager()->getCountryById($id);

        return $countryDetails;
    }

}

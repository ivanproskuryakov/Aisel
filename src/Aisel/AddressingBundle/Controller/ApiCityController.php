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
 * Frontend Addressing Cities REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCityController extends Controller
{

    /**
     * Addressing manager
     */
    private function getAddressingManager()
    {
        return $this->get('aisel.addressing.manager');
    }

    /**
     * /%website_api%/addressing/city/list.json
     *
     * @return JsonResponse $response
     */
    public function cityListAction()
    {
        $countryList = $this->getAddressingManager()->getCities();

        return $countryList;
    }

    /**
     * /%website_api%/addressing/city/{id}.json
     *
     * @param integer $id
     *
     * @return JsonResponse $response
     */
    public function cityDetailsAction($id)
    {
        $countryDetails = $this->getAddressingManager()->getCityById($id);

        return $countryDetails;
    }
}

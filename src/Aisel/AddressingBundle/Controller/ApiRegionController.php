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
 * Frontend Addressing Regions REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiRegionController extends Controller
{

    /**
     * Addressing manager
     */
    private function getAddressingManager()
    {
        return $this->get('aisel.addressing.manager');
    }

    /**
     * /%website_api%/addressing/region/list.json
     *
     * @return JsonResponse $response
     */
    public function regionListAction()
    {
        $countryList = $this->getAddressingManager()->getRegions();

        return $countryList;
    }

    /**
     * /%website_api%/addressing/region/{id}.json
     *
     * @param integer $id
     *
     * @return JsonResponse $response
     */
    public function regionDetailsAction($id)
    {
        $countryDetails = $this->getAddressingManager()->getRegionById($id);

        return $countryDetails;
    }
}

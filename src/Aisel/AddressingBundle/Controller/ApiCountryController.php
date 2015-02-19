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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * Get country collection
     *
     * @return JsonResponse
     */
    public function getCollectionAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'filter' => $request->get('filter')
        );

        return $this->getAddressingManager()->getCountries($params);
    }

    /**
     * Get single country entity
     *
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function getAction($id)
    {
        $countryDetails = $this->getAddressingManager()->getCountryById($id);

        return $countryDetails;
    }

}

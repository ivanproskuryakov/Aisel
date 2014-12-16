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
 * Frontend Addressing Regions REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiRegionController extends Controller
{

    /**
     * /%website_api%/addressing/region/list.json
     */
    public function regionListAction(Request $request)
    {
        // TODO: finish addressing API functionality
        $regionList = false;
        return $regionList;
    }

    /**
     * /%website_api%/addressing/region/{id}.json
     */
    public function regionDetailsAction($id)
    {
        // TODO: finish addressing API functionality
        $regionDetails = $id;
        return $regionDetails;
    }
}

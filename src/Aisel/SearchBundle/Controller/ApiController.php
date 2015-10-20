<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * searchAction
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function searchAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'query' => $request->get('query'),
            'order' => $request->get('order'),
            'orderby' => $request->get('orderby'),
            'locale' => $request->get('locale'),
            'scope' => 'frontend',
        );

        if (!$params['query']) {
            return false;
        };

        $results = $this
            ->container
            ->get("aisel.search.manager")
            ->search($params);

        return $results;
    }

}

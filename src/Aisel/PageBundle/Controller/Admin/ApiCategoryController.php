<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category REST API for Frontend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiCategoryController extends Controller
{

    /**
     * /backend/api/page/category/list.json?limit=2&current=3
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getListAction(Request $request)
    {
        $params = array(
            'current' => $request->query->get('current'),
            'limit' => $request->query->get('limit'),
        );

        $categoryList = $this->container->get("aisel.pagecategory.manager")->getCategories($params);
        return $categoryList;
    }

    /**
     * /backend/api/page/category/view/{$id}.json
     *
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getAction($id)
    {
        $category = $this->container->get("aisel.pagecategory.manager")->getCategory($id);

        return $category;
    }

}

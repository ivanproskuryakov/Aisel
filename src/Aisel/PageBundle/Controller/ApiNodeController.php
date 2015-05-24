<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ApiNodeController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeController extends Controller
{

    /**
     * categoryListAction
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return mixed $categoryList
     */
    public function categoryListAction(Request $request, $locale)
    {
        $params = array(
            'current' => $request->query->get('current'),
            'limit' => $request->query->get('limit'),
        );
        $categoryList = $this
            ->container
            ->get("aisel.pagecategory.node.manager")
            ->getCategories($params, $locale);

        return $categoryList;
    }

    /**
     * getTreeAction
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return mixed $categoryList
     */
    public function getTreeAction(Request $request, $locale)
    {
        $tree = $this
            ->container
            ->get("aisel.pagecategory.node.manager")
            ->getNodesTree($locale);

        return $tree;
    }

    /**
     * categoryViewAction
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @return mixed $category
     */
    public function categoryViewAction($urlKey, $locale)
    {
        $category = $this->container->get("aisel.pagecategory.node.manager")->getCategoryByUrl($urlKey, $locale);

        return $category;
    }

}

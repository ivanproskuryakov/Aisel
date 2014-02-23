<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\Controller;

use Aisel\PageBundle\Entity\Page as Page;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{

    /**
     * @Rest\View
     * /api/category/list.json?limit=2&current=3
     */
    public function categoryListAction(Request $request)
    {
        $params = array(
            'current'=>$request->query->get('current'),
            'limit'=>$request->query->get('limit'),
        );

        $categoryList = $this->container->get("aisel.category.manager")->getCategories($params);
        return $categoryList;
    }

    /**
     * @Rest\View
     * /api/category/tree.json
     */
    public function categoryTreeAction(Request $request)
    {
        $categoryList = $this->container->get("aisel.category.manager")->getHTMLCategoryTree();
        return $categoryList;
    }

    /**
     * @Rest\View
     * /api/category/view/{$$urlKey}.json
     */
    public function categoryViewAction($urlKey)
    {
        $category = $this->container->get("aisel.category.manager")->getCategoryByUrl($urlKey);
        return $category;
    }

}

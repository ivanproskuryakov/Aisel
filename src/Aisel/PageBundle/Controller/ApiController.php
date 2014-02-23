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

use Aisel\PageBundle\Entity\Page as Page;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{

    /**
     * @Rest\View
     * /api/search/?query=abc
     */
    public function searchAction(Request $request)
    {
        $params = array(
            'current'=>$request->query->get('current'),
            'limit'=>$request->query->get('limit'),
            'query'=>$request->query->get('query'),
            'order'=>$request->query->get('order'),
            'orderby'=>$request->query->get('orderby'),
        );

        $searchResult = $this->container->get("aisel.search.manager")->search($params);
        return $searchResult;

    }

    /**
     * @Rest\View
     * /api/page/list.json?limit=2&current=3
     */
    public function pageListAction(Request $request)
    {
        $params = array(
            'current'=>$request->query->get('current'),
            'limit'=>$request->query->get('limit'),
        );

        $pageList = $this->container->get("aisel.page.manager")->getPages($params);
        return $pageList;

    }

    /**
     * @Rest\View
     */
    public function pageViewAction($urlKey)
    {
        /** @var \Aisel\PageBundle\Entity\Page $page */
        $page = $this->container->get("aisel.page.manager")->getPageByURL($urlKey);

        return $page;
    }
}

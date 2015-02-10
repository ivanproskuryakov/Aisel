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
 * Backend Page REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiPageController extends Controller
{

    /**
     * /backend/api/page/?limit=2&current=3
     *
     * @param Request $request
     * @param string $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getListAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
        );

        $pageList = $this->container->get("aisel.page.manager")->getPages($params);
        return $pageList;
    }

    /**
     * /backend/api/page/12
     *
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getAction($id)
    {
        /** @var \Aisel\PageBundle\Entity\Page $page */
        $page = $this->container->get("aisel.page.manager")->getPage($id);

        return $page;
    }

}

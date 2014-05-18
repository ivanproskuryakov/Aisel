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

/**
 * Frontend Page REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiUserController extends Controller
{

    /**
     * @Rest\View
     * /api/user/page/edit.json?...
     */
    public function pageEditAction(Request $request)
    {
        exit();
//        $userId = $this->get('security.context')->getToken()->getUser()->getId();
//        $params = array(
//            'current'=>$request->query->get('current'),
//            'limit'=>$request->query->get('limit'),
//            'category'=>$request->query->get('category'),
//            'user_id'=> $request->query->get('userid'),
//        );
//
//        $pageList = $this->container->get("aisel.page.manager")->getPages($params);
//        return $pageList;
    }

}

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
     */
    public function pageDetailsAction($pageId)
    {
        $page = $this->container->get("aisel.userpage.manager")->getPageById($pageId);
        return $page;
    }

    /**
     * @Rest\View
     */
    public function pageEditAction($pageId, Request $request)
    {
        $details = $request->get('details');
        if ($details) {
            $page = $this->container->get("aisel.userpage.manager")->updatePageId($pageId, $details);
        } else {
            return array('message'=>'Empty page details.');
        }

        return array('message'=>'Page details updated!');

//        exit();
//        $pageDetails = array(
//            'id' => $pageId,
//            'page' => $request->get('page'),
//            'categories' => $request->get('categories')
//        );
//        return $page;
    }

    /**
     * @Rest\View
     */
    public function pageAddAction(Request $request)
    {
//        /** @var \Aisel\PageBundle\Entity\Page $page */
//        $page = $this->container->get("aisel.userpage.manager")->getPageById($pageId);
//        return $page;
        $details = $request->get('details');
        if ($details) {
            $page = $this->container->get("aisel.userpage.manager")->addPage($details);
        } else {
            return array('message'=>'Empty page details.');
        }

        return array('message'=>'Page added ');
    }

}

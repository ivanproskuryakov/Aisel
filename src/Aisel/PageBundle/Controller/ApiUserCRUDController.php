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

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Page for user operations / REST Controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiUserCRUDController extends Controller
{

    /**
     * @Rest\View
     */
    public function pageDetailsAction($pageId)
    {
        $page = $this->container->get("aisel.userpage.manager")->getPageDetailsById($pageId);

        return $page;
    }

    /**
     * @Rest\View
     */
    public function pageEditAction($pageId, Request $request)
    {
        $pageDetails = $request->get('details');

        if ($pageDetails) {
            $this->container->get("aisel.userpage.manager")->updatePageId($pageId, $pageDetails);
        } else {
            return array('message' => 'Empty page details.');
        }

        return array(
            'message' => 'Page details updated!',
            'status' => 'success');

    }

    /**
     * @Rest\View
     */
    public function pageDeleteAction($pageId)
    {
        $this->container->get("aisel.userpage.manager")->deletePageId($pageId);

        return array(
            'message' => 'Page Deleted!',
            'status' => 'success');
    }

    /**
     * @Rest\View
     */
    public function pageAddAction(Request $request)
    {
        /** @var \Aisel\PageBundle\Entity\Page $page */

        $details = $request->get('details');
        $jsonDetails = utf8_decode($details);
        $pageDetails = json_decode($jsonDetails);

//        var_dump($pageDetails);
        // Check for required minimum
        if (!$pageDetails) return array('message' => 'Empty page details');
        if (empty($pageDetails->page->title)) return array('message' => 'Empty title');
        if (empty($pageDetails->page->content)) return array('message' => 'Empty page content');

        $page = $this->container->get("aisel.userpage.manager")->addPage($pageDetails);

        return array(
            'message' => 'Page successfully added!',
            'status' => 'success',
            'pageid' => $page->getId());
    }

}

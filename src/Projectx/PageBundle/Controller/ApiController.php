<?php

namespace Projectx\PageBundle\Controller;

use Projectx\PageBundle\Entity\Page as Page;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{

    /**
     * @Rest\View
     */
    public function pageListAction()
    {
//        $r = $this->container->get("projectx.page.admin");
//        vat_dump($r);
//        exit();

        $pageList = $this->container->get("projectx.page.manager")->getPages();
        return array('pageList' => $pageList);

    }

    /**
     * @Rest\View
     */
    public function pageViewAction($id)
    {
        $page = $this->container->get("projectx.page.manager")->getPage($id);
        return array('page' => $page);

    }
}

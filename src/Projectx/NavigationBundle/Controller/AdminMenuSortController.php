<?php

namespace Projectx\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminNavigationSortController extends Controller
{

    public function upAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('ProjectxNavigationBundle:Navigation');
        $page = $repo->findOneById($id);
        if ($page->getParent()){
            $repo->moveUp($page);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function downAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('ProjectxNavigationBundle:Navigation');
        $category = $repo->findOneById($id);
        if ($category->getParent()){
            $repo->moveDown($category);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}

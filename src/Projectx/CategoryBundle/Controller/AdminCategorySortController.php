<?php

namespace Projectx\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCategorySortController extends Controller
{

    public function upAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('ProjectxCategoryBundle:Category');
        $page = $repo->findOneById($id);
        if ($page->getParent()){
            $repo->moveUp($page);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function downAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('ProjectxCategoryBundle:Category');
        $category = $repo->findOneById($id);
        if ($category->getParent()){
            $repo->moveDown($category);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}

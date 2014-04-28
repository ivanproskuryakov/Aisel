<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Page sort for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MenuSortController extends Controller
{

    public function upAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AiselNavigationBundle:Menu');
        $page = $repo->findOneById($id);
        if ($page->getParent()){
            $repo->moveUp($page);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function downAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AiselNavigationBundle:Menu');
        $category = $repo->findOneById($id);
        if ($category->getParent()){
            $repo->moveDown($category);
        }
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}

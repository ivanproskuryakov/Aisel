<?php

namespace Projectx\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjectxPageBundle:Default:index.html.twig');
    }
}

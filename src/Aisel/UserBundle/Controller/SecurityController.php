<?php

namespace Aisel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{

    public function testAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        var_dump($user);
        exit();

    }
}
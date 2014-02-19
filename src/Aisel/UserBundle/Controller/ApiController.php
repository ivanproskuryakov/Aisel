<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Controller;

use Aisel\UserBundle\Entity\FrontendUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{

    protected function getUserManager()
    {
        return $this->get('frontend.user.manager');
    }

    protected function isAuthenticated()
    {
        if ($this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN') === false) {
            return $this->container->get('security.context')->isGranted('ROLE_USER');
        }
        return false;
    }

    protected function loginUser(FrontendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));
    }

    /**
     * @Rest\View
     */
    public function loginAction()
    {

        if(! $this->isAuthenticated() ){
            $request = $this->getRequest();
            $username = $request->get('username');
            $password = $request->get('password');

            /** @var \Aisel\UserBundle\Entity\FrontendUserRepository $um */
            $um = $this->getUserManager();
            $user = $um->loadUserByUsername($username);

            if ((!$user instanceof FrontendUser) || (!$this->getUserManager()->checkUserPassword($user, $password)))
                return array('message'=>'Wrong username or password');

            $this->loginUser($user);

            return array('status'=>true, 'message'=>'successully logged in');
        } else {
            return array('message'=>'You already logged in');
        }

        return array('message'=>'Error in login action');
    }

    /**
     * @Rest\View
     */
    public function registerAction()
    {
        if ($this->isAuthenticated())
            return array('message'=>'You already logged in, Please logout first');



        $request = $this->getRequest();
        $userData = array(
            'username'=>$request->get('username'),
            'password'=>$request->get('password'),
            'email'=>$request->get('email'),
        );
        $username = $request->get('username');

        $user = $this->getUserManager()->loadUserByUsername($username);
            return array('message'=> 'Username: '. $username .' already taken!');

        // TODO: Add is email taken validation


        $user = $this->getUserManager()->registerUser($userData);

        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
        }

        return array('status'=>true,'message'=>'User has been registered ');
    }

    /**
     * @Rest\View
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new FrontendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();
        return array('success'=>true,'message'=>'You have been successfully logged out!');
    }

    /**
     * @Rest\View
     */
    public function informationAction()
    {
        if ($this->isAuthenticated()) {
            return $this->get('security.context')->getToken()->getUser();
        } else {
            return false;
        }

    }



}

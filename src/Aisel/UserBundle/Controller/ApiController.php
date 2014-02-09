<?php

namespace Aisel\UserBundle\Controller;

use Aisel\UserBundle\Entity\FrontendUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        return $this->get('frontend.user.provider');
    }

    /**
     * @Rest\View
     */
    public function loginAction()
    {
//        $user = $this->get('security.context')->getToken()->getUser();
//        if(!is_object($user)) {

        if(! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $request = $this->getRequest();
            $username = $request->get('username');
            $password = $request->get('password');

            /** @var \Aisel\UserBundle\Entity\FrontendUserRepository $um */
            $um = $this->getUserManager();
            $user = $um->loadUserByUsername($username);

            if(!$user instanceof FrontendUser){
                throw new NotFoundHttpException("User not found");
            }

            if(!$this->checkUserPassword($user, $password)){
                throw new AccessDeniedException("Wrong password");
            }
            $this->loginUser($user);
            $status = array('success'=>true, 'status'=>'successully logged in');

        } else {
            $status = array('success'=>true, 'status'=>'already logged');
//            $user = $this->get('security.context')->getToken()->getUser();
        }

        return $status;
    }

    /**
     * @Rest\View
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new FrontendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();
        return array('success'=>true);
    }

    /**
     * @Rest\View
     */
    public function registerAction()
    {
        $request = $this->getRequest();
        $userData = array(
            'username'=>$request->get('username'),
            'password'=>$request->get('password'),
            'email'=>$request->get('email'),
        );

        $result = $this->registerUser($userData);
        return array('success'=>$result);
    }

    /**
     * @Rest\View
     */
    public function informationAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(!is_object($user)) {
            return array('success'=>false);
        } else {
            $user = $this->get('security.context')->getToken()->getUser();
            return $user;
        }
    }


    protected function checkUserPassword(FrontendUser $user, $password)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
//        var_dump($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt()));
//        var_dump($user);
//        var_dump($encoder);
//        exit();

        if(!$encoder){
            return false;
        }
        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }

    protected function loginUser(FrontendUser $user)
    {

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));
    }


    protected function registerUser(Array $userData)
    {
        /** @var \Aisel\UserBundle\Entity\FrontendUserRepository $um */
        $um = $this->getUserManager();
        $factory = $this->get('security.encoder_factory');
        $user = $um->registerUser($userData,$factory);
        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
            return true;

        } else {
            return false;
        }
    }


}

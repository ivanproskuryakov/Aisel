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
        return $this->get('frontend.user.manager');
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

            if(!$this->getUserManager()->checkUserPassword($user, $password)){
                throw new AccessDeniedException("Wrong password");
            }
            $this->loginUser($user);

            $status = array('status'=>true, 'message'=>'successully logged in');
        } else {
            $status = array('status'=>false, 'message'=>'already logged');
        }

        return $status;
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

        $user = $this->getUserManager()->registerUser($userData);

        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main',serialize($token));
        }

        return array('status'=>$user);
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
    public function informationAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $user;
//        var_dump($user);
//        exit();
    }

    protected function loginUser(FrontendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));
    }


}

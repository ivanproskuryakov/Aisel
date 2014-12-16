<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FrontendUserBundle\Controller;

use Aisel\FrontendUserBundle\Entity\FrontendUser;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Api for frontend users. Login, registration, etc..
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    protected function getUserManager()
    {
        return $this->get('frontend.user.manager');
    }

    /**
     * Is User Authenticated
     *
     * @return boolean
     */
    private function isAuthenticated()
    {
        return $this->getUserManager()->isAuthenticated();
    }

    protected function loginUser(FrontendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function loginAction(Request $request)
    {
        if (!$this->isAuthenticated()) {
            $username = $request->get('username');
            $password = $request->get('password');
            /** @var \Aisel\FrontendUserBundle\Entity\FrontendUserRepository $um */
            $um = $this->getUserManager();
            $user = $um->loadUserByUsername($username);

            if ((!$user instanceof FrontendUser) || (!$this->getUserManager()->checkUserPassword($user, $password)))
                return array('message' => 'Wrong username or password!');
            $this->loginUser($user);

            return array('status' => true, 'message' => 'successully logged in');
        } else {
            return array('message' => 'You already logged in. Try to refresh page');
        }

        return array('message' => 'Error in login action');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function registerAction(Request $request)
    {
        if ($this->isAuthenticated())
            return array('message' => 'You already logged in, Please logout first');

        $userData = array(
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'email' => $request->get('email'),
        );
        $username = $request->get('username');
        $email = $request->get('email');

        if ($this->getUserManager()->findUser($username, $email))
            return array('message' => 'Username or e-mail already taken!');
        $user = $this->getUserManager()->registerUser($userData);

        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
        }

        return array('status' => true, 'message' => 'User has been registered ');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function passwordforgotAction()
    {
        if ($this->isAuthenticated())
            return array('message' => 'You already logged in, Please logout first');
        $email = $this->getRequest()->get('email');

        if ($user = $this->getUserManager()->findUserByEmail($email)) {
            $response = $this->getUserManager()->resetPassword($user);
            if ($response != 1) return array('message' => $response);
        } else {
            return array('message' => 'User not found!');
        }

        return array('status' => true, 'message' => 'New password has been sent!');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new FrontendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();

        return array('success' => true, 'message' => 'You have been successfully logged out!');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function informationAction()
    {
        if ($this->isAuthenticated()) {
            $user = $this->get('security.context')->getToken()->getUser();

            return $user;
        } else {
            return false;
        }
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editdetailsAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            $json = utf8_decode($request->get('userdata'));
            $userData = json_decode($json, true);
            $message = $this->getUserManager()->updateDetailsCurrentUser($userData);

            return array('status' => true, 'message' => $message);
        } else {
            return false;
        }
    }

}

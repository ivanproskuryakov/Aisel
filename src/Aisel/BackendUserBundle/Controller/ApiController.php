<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\BackendUserBundle\Controller;

use Aisel\BackendUserBundle\Entity\BackendUser;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Aisel\BackendUserBundle\Manager\UserManager;

/**
 * ApiController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends Controller
{

    /**
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('backend.user.manager');
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

    /**
     * Is User Authenticated
     *
     * @param BackendUser $user
     */
    protected function loginUser(BackendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('user_backend', serialize($token));
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
            $user = $this
                ->getUserManager()
                ->loadUserByUsername($username);

            if ((!$user instanceof BackendUser) || (!$this->getUserManager()->checkUserPassword($user, $password)))
                return array('message' => 'Wrong username or password!');
            $this->loginUser($user);

            return array('status' => true,
                'message' => 'Successfully logged in',
                'user' => $this->get('security.context')->getToken()->getUser()
            );
        } else {
            return array('message' => 'You already logged in. Try to refresh page');
        }

        return array('message' => 'Login error');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new BackendUser());
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

}

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

use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;
use Aisel\UserBundle\Entity\User;
use Aisel\UserBundle\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends BaseApiController
{

    /**
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('aisel.user.manager');
    }

    /**
     * Is User Authenticated
     *
     * @return boolean
     */
    private function isAuthenticated()
    {
        return $this->getUserManager()->getAuthenticatedUser();
    }

    /**
     * loginUser
     *
     * @param User $user
     */
    protected function loginUser(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

    /**
     * loginAction
     *
     * @param Request $request
     * @return User $user
     */
    public function loginAction(Request $request)
    {
        /** @var \Aisel\UserBundle\Manager\UserManager $um */

        if (!$this->isAuthenticated()) {
            $email = $request->get('email');
            $password = $request->get('password');
            $um = $this->getUserManager();
            $user = $um->loadUserByEmail($email);

            if ((!$user instanceof User) || (!$um->checkUserPassword($user, $password))) {
                throw new AccessDeniedHttpException('Wrong e-mail or password!');
            }

            $this->loginUser($user);

            return array(
                'user' => $this->filterMaxDepth($user),
            );

        } else {
            throw new AccessDeniedHttpException('You already logged in. Try to refresh page');
        }
    }

    /**
     * @param Request $request
     * @return array|false
     */
    public function registerAction(Request $request)
    {
        $params = array(
            'password' => $request->get('password'),
            'email' => $request->get('email'),
        );

        if ($this->isAuthenticated()) {
            throw new AccessDeniedHttpException('You already logged in, please logout first');
        }
        if ($this->getUserManager()->loadUserByEmail($params['email'])) {
            throw new AccessDeniedHttpException('E-mail already taken!');
        }

        $this->getUserManager()->registerUser($params);

        return new Response();
    }

    /**
     * @param Request $request
     *
     * @throw AccessDeniedHttpException
     * @return array
     */
    public function passwordForgotAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            throw new AccessDeniedHttpException('You already logged in, Please logout first');
        }

        $email = $request->get('email');

        if ($user = $this->getUserManager()->loadUserByEmail($email)) {
            $response = $this->getUserManager()->resetPassword($user);

            if ($response != 1) {
                return array('message' => $response);
            }
        } else {
            throw new AccessDeniedHttpException('User not found');
        }

        return new Response();
    }

    /**
     * logoutAction
     *
     * @return array
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new User());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->invalidate();

        return new Response();
    }


    /**
     * informationAction
     *
     * @return User
     */
    public function informationAction()
    {
        $user = $this->filterMaxDepth($this->getUser());

        return $user;
    }

    /**
     * editAction
     *
     * @param Request $request
     *
     * @return array|false
     */
    public function editAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            $userData = json_decode($request->getContent(), true);
            $this->getUserManager()->updateDetailsForUser($userData);
        }
    }

    /**
     * deleteAction
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteAction(Request $request)
    {
        if ($this->isAuthenticated()) {

            // Send Mail
            $this->container
                ->get('aisel.user_mail.manager')
                ->sendAccountTerminateEmail($this->getUser());

            // Delete entity
            $em = $this->getEntityManager();
            $em->remove($this->getUser());
            $em->flush();
            $em->clear();

            // Logout
            $token = new AnonymousToken(null, new User());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->invalidate();
        }
    }

    /**
     * changePasswordAction
     *
     * @param Request $request
     * @return mixed
     */
    public function changePasswordAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            $password = $request->get('password');

            /** @var User $user */
            $em = $this->getEntityManager();
            $user = $this->getUser();
            $user->setPassword(null); // hack to force update user password
            $user->setPlainPassword($password);

            $em->persist($user);
            $em->flush();

            // Send Mail
            $this->container
                ->get('aisel.user_mail.manager')
                ->sendNewPasswordEmail($this->getUser(), $password);
        }
    }

}

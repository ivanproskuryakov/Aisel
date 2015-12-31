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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;
use Symfony\Component\HttpFoundation\Request;
use Aisel\FrontendUserBundle\Manager\UserManager;
use LogicException;

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
        return $this->get('frontend.user.manager');
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
     * @param FrontendUser $user
     */
    protected function loginUser(FrontendUser $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

    /**
     * @param Request $request
     *
     * @return array|false
     */
    public function loginAction(Request $request)
    {
        /** @var \Aisel\FrontendUserBundle\Manager\UserManager $um */

        if (!$this->isAuthenticated()) {
            $email = $request->get('email');
            $password = $request->get('password');
            $um = $this->getUserManager();
            $user = $um->loadUserByEmail($email);

            if ((!$user instanceof FrontendUser) || (!$um->checkUserPassword($user, $password))) {
                throw new LogicException('Wrong e-mail or password!');
            }

            $this->loginUser($user);

            return array(
                'user' => $this->filterMaxDepth($user),
            );

        } else {
            throw new LogicException('You already logged in. Try to refresh page');
        }
    }

    /**
     * @param Request $request
     *
     * @return array|false
     */
    public function registerAction(Request $request)
    {
        $params = array(
            'password' => $request->get('password'),
            'email' => $request->get('email'),
        );

        if ($this->isAuthenticated()) {
            throw new LogicException('You already logged in, please logout first');
        }
        if ($this->getUserManager()->loadUserByEmail($params['email'])) {
            throw new LogicException('E-mail already taken!');
        }

        $user = $this->getUserManager()->registerUser($params);

        if ($user) {
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
        }

        return new Response();
    }

    /**
     * @param Request $request
     *
     * @throw LogicException
     * @return array
     */
    public function passwordForgotAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            throw new LogicException('You already logged in, Please logout first');
        }

        $email = $request->get('email');

        if ($user = $this->getUserManager()->loadUserByEmail($email)) {
            $response = $this->getUserManager()->resetPassword($user);

            if ($response != 1) {
                return array('message' => $response);
            }
        } else {
            throw new LogicException('User not found');
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
        $token = new AnonymousToken(null, new FrontendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();

        return new Response();
    }


    /**
     * informationAction
     *
     * @return FrontendUser|false
     */
    public function informationAction()
    {
        return $this->getUserManager()->getAuthenticatedUser();
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
                ->get('frontend.user_mail.manager')
                ->sendAccountTerminateEmail($this->getUser());

            // Delete entity
            $em = $this->getEntityManager();
            $em->remove($this->getUser());
            $em->flush();
            $em->clear();

            // Logout
            $token = new AnonymousToken(null, new FrontendUser());
            $this->get('security.context')->setToken($token);
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

            /** @var FrontendUser $user */
            $em = $this->getEntityManager();
            $user = $this->getUser();
            $user->setPassword(null); // hack to force update user password
            $user->setPlainPassword($password);

            $em->persist($user);
            $em->flush();

            // Send Mail
            $this->container
                ->get('frontend.user_mail.manager')
                ->sendNewPasswordEmail($this->getUser(), $password);
        }
    }

}

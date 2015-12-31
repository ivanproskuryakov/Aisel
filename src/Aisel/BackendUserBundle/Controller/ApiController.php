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
use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;
use Symfony\Component\HttpFoundation\Request;
use LogicException;
use Symfony\Component\HttpFoundation\Response;

/**
 * ApiController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiController extends BaseApiController
{

    /**
     * loginUser
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
        $user = $this
            ->get('backend.user.manager')
            ->getAuthenticatedUser();

        if (!$user) {
            $email = $request->get('email');
            $password = $request->get('password');

            $user = $this
                ->get('backend.user.manager')
                ->loadUserByEmail($email);
            $isPasswordValid = $this
                ->get('backend.user.manager')
                ->checkUserPassword($user, $password);

            if ((!$user instanceof BackendUser) || ($isPasswordValid == false)) {
                throw new LogicException('Wrong email or password!');
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logoutAction()
    {
        $token = new AnonymousToken(null, new BackendUser());
        $this->get('security.context')->setToken($token);
        $this->get('session')->invalidate();

        return new Response();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function informationAction()
    {
        return $this
            ->get('backend.user.manager')
            ->getAuthenticatedUser();
    }

}

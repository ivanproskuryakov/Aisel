<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manager for Cart, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartManager
{
    protected $sc;
    protected $em;
    protected $securityContext;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer, $entityManager, $securityContext)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
        $this->securityContext = $securityContext;
    }

    /**
     * User manager
     */
    private function getUser()
    {
        $currentUser = false;
        $userToken = $this->securityContext->getToken();

        if ($userToken) {
            $user = $userToken->getUser();
            if ($user !== 'anon.') {
                $roles = $user->getRoles();
                if (in_array('ROLE_USER', $roles)) $currentUser = $user;
            }
        }
        return $currentUser;
    }

    /**
     * Get get cart with products for authenticated user
     *
     * @return \Aisel\CartBundle\Entity\Cart $cart
     *
     * @throws NotFoundHttpException
     */
    public function getUserCart()
    {
        $products = false;
        if ($this->getUser()) {
            $userId = $this->getUser()->getId();
            $products = $this->em->getRepository('AiselCartBundle:Cart')
                ->findBy(array('frontenduser' => $userId));
        }
        return $products;
    }

    /**
     * Adds product to customer cart by mentioned $id and $qty
     *
     * @param int $id
     * @param int $qty
     *
     * @return array $response
     *
     * @throws NotFoundHttpException
     */
    public function addProductToCart($id, $qty = 1)
    {
        $response = array(
            'status' => false,
            'message' => 'Product does not exists'
        );
        return $response;
    }

    /**
     * Removes product from customers cart by mentioned $id and $qty
     *
     * @param int $id
     * @param int $qty
     *
     * @return array $response
     *
     * @throws NotFoundHttpException
     */
    public function removeProductFromCart($id, $qty = null)
    {
        $response = array(
            'status' => false,
            'message' => 'Product not in cart'
        );
        return $response;
    }


}

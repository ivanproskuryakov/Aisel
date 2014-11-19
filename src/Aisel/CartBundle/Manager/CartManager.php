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

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer, $entityManager)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
    }

    /**
     * Get get cart with products for $userId
     *
     * @param integer $userId
     *
     * @return \Aisel\CartBundle\Entity\Cart $cart
     *
     * @throws NotFoundHttpException
     */
    public function getUserCart($userId)
    {
        $products = $this->em->getRepository('AiselCartBundle:Cart')
            ->findBy(array('frontenduser' => $userId));

        return $products;
    }

    /**
     * Adds product to customer cart by mentioned $id and $qty
     *
     * @param int $userId
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     *
     * @throws NotFoundHttpException
     */
    public function addProductToCart($userId, $productId, $qty = 1)
    {

//        $cart = new Cart();
//        $cart->setFrontenduser($frontendUser);
//        $cart->setQty((int)$table->column[2]);
//        $cart->setProduct($product);
//        $cart->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $response = array(
            'status' => false,
            'message' => 'Product does not exists'
        );
        return $response;
    }

    /**
     * Removes product from customers cart by mentioned $id and $qty
     *
     * @param int $userId
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     *
     * @throws NotFoundHttpException
     */
    public function removeProductFromCart($userId, $productId, $qty = null)
    {
        $response = array(
            'status' => false,
            'message' => 'Product not in cart'
        );
        return $response;
    }


}

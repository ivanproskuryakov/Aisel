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
    protected $userManager;
    protected $productManager;

    /**
     * {@inheritDoc}
     */
    public function __construct($serviceContainer, $entityManager,
                                $frontendUserManager, $productManager)
    {
        $this->sc = $serviceContainer;
        $this->em = $entityManager;
        $this->userManager = $frontendUserManager;
        $this->productManager = $productManager;
    }

    /**
     * Cart manager
     */
    private function getProductManager()
    {
        return $this->productManager;
    }

    /**
     * User manager
     */
    private function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * Get get cart products for given $userId
     *
     * @param integer $userId
     *
     * @return \Aisel\CartBundle\Entity\Cart|boolean $products
     */
    public function getUserCart($userId)
    {
        $products = $this->em->getRepository('AiselCartBundle:Cart')->findBy(array('frontenduser' => $userId));
        return $products;
    }

    /**
     * Adds product to cart by given $id and $qty
     *
     * @param int $userId
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     */
    public function addProductToCart($userId, $productId, $qty = 1)
    {
        $user = $this->getUserManager()->loadById($userId);
        $product = $this->getProductManager()->loadById($productId);
        $cartItem = $this->em->getRepository('AiselCartBundle:Cart')->addProduct($user, $product, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'cartItem' => $cartItem);
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during adding to cart');
        }
        return $response;
    }

    /**
     * Updates product item inside cart by given $id and $qty
     *
     * @param int $userId
     * @param int $productId
     * @param int $qty
     *
     * @return array $response
     */
    public function updateProductInCart($userId, $productId, $qty = null)
    {
        $user = $this->getUserManager()->loadById($userId);
        $product = $this->getProductManager()->loadById($productId);
        $cartItem = $this->em->getRepository('AiselCartBundle:Cart')->updateProduct($user, $product, $qty);

        if ($cartItem) {
            $response = array('status' => true, 'cartItem' => $cartItem);
        } else {
            $response = array('status' => false, 'message' => 'Something went wrong during removing from the cart');
        }
        return $response;
    }


}

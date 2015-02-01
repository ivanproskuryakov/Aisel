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
    protected $em;
    protected $userManager;
    protected $productManager;

    /**
     * {@inheritDoc}
     */
    public function __construct($entityManager, $frontendUserManager, $productManager)
    {
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
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     *
     * @return \Aisel\CartBundle\Entity\Cart $cartItems
     */
    public function getUserCart($user)
    {
        $cartItems = $this->em->getRepository('AiselCartBundle:Cart')->findBy(array('frontenduser' => $user));

        return $cartItems;
    }

    /**
     * Adds product to cart by given $id and $qty
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param int                                           $productId
     * @param int                                           $qty
     *
     * @return \Aisel\CartBundle\Entity\Cart $cartItem
     *
     * @throws NotFoundHttpException
     */
    public function addProductToCart($user, $productId, $qty = 1)
    {
        if (!($user)) throw new NotFoundHttpException('User object is missing');

        $product = $this->getProductManager()->loadById($productId);
        $cartItem = $this->em->getRepository('AiselCartBundle:Cart')->addProduct($user, $product, $qty);

        return $cartItem;
    }

    /**
     * Updates product item inside cart by given $id and $qty
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $user
     * @param int                                           $productId
     * @param int                                           $qty
     *
     * @return \Aisel\CartBundle\Entity\Cart $cartItem
     *
     * @throws NotFoundHttpException
     */
    public function updateProductInCart($user, $productId, $qty = null)
    {
        if (!($user)) throw new NotFoundHttpException('User object is missing');

        $product = $this->getProductManager()->loadById($productId);
        $cartItem = $this->em->getRepository('AiselCartBundle:Cart')->updateProduct($user, $product, $qty);

        return $cartItem;
    }

}

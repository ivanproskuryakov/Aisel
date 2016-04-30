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

use Aisel\CartBundle\Entity\Cart;
use Aisel\ProductBundle\Entity\Product;
use Aisel\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use LogicException;

/**
 * CartManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class CartManager
{

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->dm = $entityManager;
    }

    /**
     * Get get cart products for given $userId
     *
     * @param int $productId
     *
     * @return Product $product
     */
    public function loadProductById($productId)
    {
        $product = $this->dm->find('Aisel\ProductBundle\Entity\Product', $productId);

        if (!$product) {
            throw new LogicException('Product was not found');
        }

        return $product;
    }

    /**
     * Get get cart products for given $userId
     *
     * @param $user
     *
     * @return Cart|false
     */
    public function getUserCart($user)
    {
        if ($user) {
            return $this->dm
                ->getRepository('Aisel\CartBundle\Entity\Cart')
                ->findBy(array('user' => $user->getId()));
        }

        return [];
    }

    /**
     * Adds product to cart by given $id and $qty
     *
     * @param User $user
     * @param int $productId
     * @param int $qty
     *
     * @return Cart $cartItem
     *
     * @throws LogicException
     */
    public function addProductToCart($user, $productId, $qty = 1)
    {
        if (!$user) {
            throw new LogicException('User object is missing');
        }

        $product = $this->loadProductById($productId);
        $cartItem = $this
            ->dm
            ->getRepository('Aisel\CartBundle\Entity\Cart')
            ->addProduct($user, $product, $qty);

        return $cartItem;
    }

    /**
     * Updates product item inside cart by given $id and $qty
     *
     * @param User $user
     * @param int $productId
     * @param int $qty
     *
     * @return Cart $cartItem
     *
     * @throws LogicException
     */
    public function updateProductInCart($user, $productId, $qty = null)
    {
        if (!$user) {
            throw new LogicException('User object is missing');
        }
        $product = $this->loadProductById($productId);
        $cartItem = $this
            ->dm
            ->getRepository('Aisel\CartBundle\Entity\Cart')
            ->updateProduct($user, $product, $qty);

        return $cartItem;
    }

}

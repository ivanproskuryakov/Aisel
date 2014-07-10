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
use Aisel\AdminBundle\Utility\UrlUtility;

/**
 * Manager for Cart, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get categories in array for cart
     * @param  int $cart
     * @return array $categories
     */
    public function getCartCategories($cart)
    {
        $categories = array();
        foreach ($cart->getCategories() as $c) {
            $category = array();
            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $categories[$c->getId()] = $category;
        }

        return $categories;
    }

    /**
     * Get list of all carts
     * @param  array $params
     * @return array
     */
    public function getCarts($params)
    {
        $total = $this->em->getRepository('AiselCartBundle:Cart')->getTotalFromRequest($params);
        $carts = $this->em->getRepository('AiselCartBundle:Cart')->getCurrentCartsFromRequest($params);

        $return = array(
            'total' => $total,
            'carts' => $carts
        );

        return $return;
    }

    /**
     * Get single detailed cart with category by ID
     * @param  int $id
     * @return \Aisel\CartBundle\Entity\Cart $cartDetails
     */
    public function getCart($id)
    {
        $cart = $this->em->getRepository('AiselCartBundle:Cart')->find($id);

        if (!($cart)) {
            throw new NotFoundHttpException('Nothing found');
        }

        $cartDetails = array('cart' => $cart, 'categories' => $this->getCartCategories($cart));

        return $cartDetails;
    }

    /**
     * Get single detailed cart with category by URLKey
     * @param  string $urlKey
     * @return \Aisel\CartBundle\Entity\Cart $cart
     */
    public function getCartByURL($urlKey)
    {

        $cart = $this->em->getRepository('AiselCartBundle:Cart')->findOneBy(array('metaUrl' => $urlKey));

        if (!($cart)) {
            throw new NotFoundHttpException('Nothing found');
        }

        $cartDetails = array('cart' => $cart, 'categories' => $this->getCartCategories($cart));

        return $cartDetails;
    }

    /**
     * validate metaUrl for Cart Entity and return one we can use
     * @param  string $url
     * @param  int $cartId
     * @return string $validUrl
     */
    public function normalizeCartUrl($url, $cartId = null)
    {
        $cart = $this->em->getRepository('AiselCartBundle:Cart')->findTotalByURL($url, $cartId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);
        if ($cart) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

    /**
     * Get List of all carts, except disabled
     * @return string
     */
    public function getEnabledCarts()
    {
        $cartList = $this->em->getRepository('AiselCartBundle:Cart')->getEnabledCarts();

        return $cartList;
    }

}

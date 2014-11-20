<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aisel\ResourceBundle\Utility\UrlUtility;

/**
 * Manager for Products, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductManager
{
    protected $sc;
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get categories in array for product
     * @param  int $product
     * @return array $categories
     */
    public function getProductCategories($product)
    {
        $categories = array();

        foreach ($product->getCategories() as $c) {
            $category = array();
            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $categories[$c->getId()] = $category;
        }
        return $categories;
    }

    /**
     * Get list of all products
     * @param  array $params
     * @return array
     */
    public function getProducts($params)
    {
        $total = $this->em->getRepository('AiselProductBundle:Product')->getTotalFromRequest($params);
        $products = $this->em->getRepository('AiselProductBundle:Product')->getCurrentProductsFromRequest($params);
        $return = array(
            'total' => $total,
            'products' => $products
        );
        return $return;
    }

    /**
     * Get single detailed product with category by ID
     *
     * @param int $id
     *
     * @return \Aisel\ProductBundle\Entity\Product $productDetails
     *
     * @throws NotFoundHttpException
     */
    public function getProduct($id)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->find($id);

        if (!($product)) {
            throw new NotFoundHttpException('Nothing found');
        }
        $productDetails = array('product' => $product, 'categories' => $this->getProductCategories($product));
        return $productDetails;
    }

    /**
     * Get single detailed product with category by URLKey
     *
     * @param string $urlKey
     *
     * @return \Aisel\ProductBundle\Entity\Product $product
     *
     * @throws NotFoundHttpException
     */
    public function getProductByURL($urlKey)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->findOneBy(array('metaUrl' => $urlKey));

        if (!($product)) {
            throw new NotFoundHttpException('Nothing found');
        }
        $productDetails = array('product' => $product, 'categories' => $this->getProductCategories($product));
        return $productDetails;
    }

    /**
     * validate metaUrl for Product Entity and return one we can use
     *
     * @param string $url
     *
     * @param int $productId
     *
     * @return string $validUrl
     */
    public function normalizeProductUrl($url, $productId = null)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->findTotalByURL($url, $productId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($product) {
            $validUrl = $validUrl . '-' . time();
        }
        return $validUrl;
    }

    /**
     * Get List of all products, except disabled
     * @return string
     */
    public function getEnabledProducts()
    {
        $productList = $this->em->getRepository('AiselProductBundle:Product')->getEnabledProducts();
        return $productList;
    }

    /**
     * load product object by productId
     *
     * @param integer $productId
     *
     * @return \Aisel\ProductBundle\Entity\Product $product
     *
     * @throws NotFoundHttpException
     */
    public function loadById($productId)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->findOneBy(array('id' => $productId));

        if (!($product)) {
            throw new NotFoundHttpException('Nothing found');
        }
        return $product;
    }

}

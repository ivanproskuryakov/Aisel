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

use Aisel\ResourceBundle\Utility\UrlUtility;
use LogicException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manager for Products, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get single detailed product with category by URLKey
     *
     * @param string $urlKey
     *
     * @return \Aisel\ProductBundle\Entity\Product $product
     *
     * @throws LogicException
     */
    public function getProductByURL($urlKey)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->findOneBy(array('metaUrl' => $urlKey));

        if (!($product)) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product;
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
     * @throws LogicException
     */
    public function loadById($productId)
    {
        $product = $this->em->getRepository('AiselProductBundle:Product')->findOneBy(array('id' => $productId));

        if (!($product)) {
            throw new NotFoundHttpException('Product not found');
        }

        return $product;
    }

}

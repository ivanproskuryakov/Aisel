<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Aisel\ProductBundle\Document\Product;
use Aisel\MediaBundle\Document\Image as BaseImage;
use JMS\Serializer\Annotation as JMS;

/**
 * Image
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_product_image"
 * )
 */
class Image extends BaseImage
{
//
//    /**
//     * @var Product
//     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Document\Product", inversedBy="images")
//     * @JMS\Expose
//     * @JMS\MaxDepth(1)
//     * @JMS\Type("Aisel\ProductBundle\Document\Product")
//     */
//    protected $product;
//
//    /**
//     * Set product
//     *
//     * @param  Product $product
//     * @return Image
//     */
//    public function setProduct(Product $product = null)
//    {
//        $this->product = $product;
//
//        return $this;
//    }
//
//    /**
//     * Get product
//     *
//     * @return Product
//     */
//    public function getProduct()
//    {
//        return $this->product;
//    }

}

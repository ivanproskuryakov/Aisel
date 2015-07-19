<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Aisel\MediaBundle\Entity\Image as BaseImage;

/**
 * Image
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ProductBundle\Entity\ImageRepository")
 * @ORM\Table(name="aisel_product_image")
 */
class Image extends BaseImage
{

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="images")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * Set product
     *
     * @param  Product $product
     * @return Image
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Aisel\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Aisel\ProductBundle\Document\Product;
use Aisel\FrontendUserBundle\Document\FrontendUser;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;

/**
 * Cart
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_cart",
 *      repositoryClass="Aisel\CartBundle\Document\CartRepository"
 * )
 * @JMS\ExclusionPolicy("none")
 */
class Cart
{

    use IdTrait;
    use QtyTrait;

    /**
     * @var FrontendUser
     * @ODM\ReferenceOne(targetDocument="Aisel\FrontendUserBundle\Document\FrontendUser", inversedBy="cart")
     * @JMS\Exclude
     * @JMS\Type("Aisel\FrontendUserBundle\Document\FrontendUser")
     */
    private $frontenduser;

    /**
     * @var Product
     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Document\Product", inversedBy="cart")
     * @JMS\Type("Aisel\ProductBundle\Document\Product")
     * @JMS\MaxDepth(3)
     */
    private $product;

    /**
     * Set frontenduser
     *
     * @param  FrontendUser $frontenduser
     * @return Cart
     */
    public function setFrontenduser(FrontendUser $frontenduser = null)
    {
        $this->frontenduser = $frontenduser;

        return $this;
    }

    /**
     * Get frontenduser
     *
     * @return FrontendUser
     */
    public function getFrontenduser()
    {
        return $this->frontenduser;
    }

    /**
     * Set product
     *
     * @param  Product $product
     * @return Cart
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

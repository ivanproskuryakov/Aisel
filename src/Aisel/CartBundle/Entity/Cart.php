<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Aisel\ProductBundle\Entity\Product;
use Aisel\FrontendUserBundle\Entity\FrontendUser;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;

/**
 * Cart
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ODM\Entity(
 *      table="aisel_cart",
 *      repositoryClass="Aisel\CartBundle\Entity\CartRepository"
 * )
 * @JMS\ExclusionPolicy("none")
 */
class Cart
{

    use IdTrait;
    use QtyTrait;

    /**
     * @var FrontendUser
     * @ODM\ReferenceOne(targetDocument="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="cart")
     * @JMS\Exclude
     * @JMS\Type("Aisel\FrontendUserBundle\Entity\FrontendUser")
     */
    private $frontenduser;

    /**
     * @var Product
     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Entity\Product", inversedBy="cart")
     * @JMS\Type("Aisel\ProductBundle\Entity\Product")
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

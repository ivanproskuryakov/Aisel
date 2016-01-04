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
 * @ORM\Table(name="aisel_cart")
 * @ORM\Entity(repositoryClass="Aisel\CartBundle\Entity\CartRepository")
 * @JMS\ExclusionPolicy("none")
 */
class Cart
{

    use IdTrait;
    use QtyTrait;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Exclude
     * @JMS\Type("Aisel\FrontendUserBundle\Entity\FrontendUser")
     */
    private $frontenduser;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="cart")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
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

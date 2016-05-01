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

use Aisel\ProductBundle\Entity\Product;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;
use Aisel\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="Aisel\UserBundle\Entity\User", inversedBy="cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Exclude
     * @JMS\Type("Aisel\UserBundle\Entity\User")
     * @JMS\Groups({"collection","details"})
     */
    private $user;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="cart")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @JMS\Type("Aisel\ProductBundle\Entity\Product")
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"collection","details"})
     */
    private $product;

    /**
     * Set user
     *
     * @param  User $user
     * @return Cart
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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

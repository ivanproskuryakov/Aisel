<?php

namespace Aisel\CartBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Aisel\ProductBundle\Entity\Product;
use Aisel\FrontendUserBundle\Entity\FrontendUser;

/**
 * Cart
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\CartBundle\Entity\CartRepository")
 * @ORM\Table(name="aisel_cart")
 */
class Cart
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $qty = 0;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $frontenduser;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="cart")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qty
     *
     * @param  integer $qty
     * @return Cart
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

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

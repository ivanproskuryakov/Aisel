<?php

namespace Aisel\CartBundle\Entity;

/**
 * Cart
 */
class Cart
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $qty;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Aisel\FrontendUserBundle\Entity\FrontendUser
     */
    private $frontenduser;

    /**
     * @var \Aisel\ProductBundle\Entity\Product
     */
    private $product;

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
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Cart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Cart
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
     * @param  \Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser
     * @return Cart
     */
    public function setFrontenduser(\Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser = null)
    {
        $this->frontenduser = $frontenduser;

        return $this;
    }

    /**
     * Get frontenduser
     *
     * @return \Aisel\FrontendUserBundle\Entity\FrontendUser
     */
    public function getFrontenduser()
    {
        return $this->frontenduser;
    }

    /**
     * Set product
     *
     * @param  \Aisel\ProductBundle\Entity\Product $product
     * @return Cart
     */
    public function setProduct(\Aisel\ProductBundle\Entity\Product $product = null)
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

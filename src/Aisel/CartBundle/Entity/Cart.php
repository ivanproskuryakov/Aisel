<?php

namespace Aisel\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
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
     * @param \DateTime $updatedAt
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
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser
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
     * Add products
     *
     * @param \Aisel\ProductBundle\Entity\Product $products
     * @return Cart
     */
    public function addProduct(\Aisel\ProductBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Aisel\ProductBundle\Entity\Product $products
     */
    public function removeProduct(\Aisel\ProductBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}

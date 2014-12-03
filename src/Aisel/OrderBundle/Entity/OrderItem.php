<?php

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItem
 */
class OrderItem
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
     * @var \Aisel\OrderBundle\Entity\Order
     */
    private $order;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return OrderItem
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
     * @return OrderItem
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
     * Set order
     *
     * @param \Aisel\OrderBundle\Entity\Order $order
     * @return OrderItem
     */
    public function setOrder(\Aisel\OrderBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Aisel\OrderBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Aisel\ProductBundle\Entity\Product $product
     * @return OrderItem
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

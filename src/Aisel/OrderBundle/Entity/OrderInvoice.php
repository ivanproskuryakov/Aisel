<?php

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderInvoice
 */
class OrderInvoice
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
     * @return OrderInvoice
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
     * @return OrderInvoice
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
     * Set product
     *
     * @param \Aisel\OrderBundle\Entity\Order $product
     * @return OrderInvoice
     */
    public function setProduct(\Aisel\OrderBundle\Entity\Order $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Aisel\OrderBundle\Entity\Order 
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @var string
     */
    private $status;

    /**
     * @var \Aisel\FrontendUserBundle\Entity\FrontendUser
     */
    private $frontenduser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $item;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->item = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set status
     *
     * @param string $status
     * @return OrderInvoice
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set frontenduser
     *
     * @param \Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser
     * @return OrderInvoice
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
     * Add item
     *
     * @param \Aisel\OrderBundle\Entity\OrderItem $item
     * @return OrderInvoice
     */
    public function addItem(\Aisel\OrderBundle\Entity\OrderItem $item)
    {
        $this->item[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Aisel\OrderBundle\Entity\OrderItem $item
     */
    public function removeItem(\Aisel\OrderBundle\Entity\OrderItem $item)
    {
        $this->item->removeElement($item);
    }

    /**
     * Get item
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItem()
    {
        return $this->item;
    }
}

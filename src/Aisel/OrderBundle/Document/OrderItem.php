<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Document;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Aisel\ProductBundle\Document\Product;
use JMS\Serializer\Annotation as JMS;
use Aisel\OrderBundle\Document\Order;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrderItem
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_order_item",
 *      repositoryClass="Aisel\PageBundle\Document\OrderItemRepository"
 * )
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
class OrderItem
{

    use UpdateCreateTrait;

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var Order
     * @ODM\ReferenceOne(targetDocument="Aisel\OrderBundle\Document\Order", inversedBy="orderItem")
     * @JMS\Expose
     */
    private $order;

    /**
     * @var Product
     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Document\Product", inversedBy="orderItem")
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Type("Aisel\ProductBundle\Document\Product")
     */
    private $product;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $title;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="integer")
     * @Assert\NotNull()
     * @JMS\Type("integer")
     */
    private $price;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="integer")
     * @Assert\NotNull()
     * @JMS\Type("integer")
     */
    private $qty;

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
     * Set order
     *
     * @param  Order $order
     * @return OrderItem
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param  Product   $product
     * @return OrderItem
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

    /**
     * Set title
     *
     * @param  string    $title
     * @return OrderItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param  integer   $price
     * @return OrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set qty
     *
     * @param  integer   $qty
     * @return OrderItem
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
     * @var string
     */
    private $name;

    /**
     * Set name
     *
     * @param  string    $name
     * @return OrderItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

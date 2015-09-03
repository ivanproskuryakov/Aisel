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

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrderItem
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_order_item",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
class OrderItem
{

    use IdTrait;
    use QtyTrait;
    use NameTrait;
    use TitleTrait;
    use UpdateCreateTrait;

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
     * @Assert\Type(type="integer")
     * @Assert\NotNull()
     * @JMS\Type("integer")
     */
    private $price;

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

}

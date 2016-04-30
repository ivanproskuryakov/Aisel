<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Entity;

use Aisel\OrderBundle\Entity\Order;
use Aisel\ProductBundle\Entity\Product;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;

use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrderItem
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_order_item")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class OrderItem
{

    use IdTrait;
    use QtyTrait;
    use NameTrait;
    use UpdateCreateTrait;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="Aisel\OrderBundle\Entity\Order", inversedBy="orderItem")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * @JMS\Expose
     */
    private $order;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="orderItem")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @JMS\Expose
     * @JMS\Type("Aisel\ProductBundle\Entity\Product")
     */
    private $product;

    /**
     * @var string
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     * @Assert\NotNull()
     * @JMS\Type("float")
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

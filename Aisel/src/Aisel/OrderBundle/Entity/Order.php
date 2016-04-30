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

use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Order
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_order")
 * @ORM\Entity(repositoryClass="Aisel\OrderBundle\Entity\OrderRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Order
{
    use IdTrait;
    use ContentTrait;
    use LocaleTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $status = 'new';

    /**
     * @var integer
     * @Assert\NotNull()
     * @ORM\Column(type="float", scale=2, nullable=false)
     * @JMS\Type("float")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $totalAmount = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $currency;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $region;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $paymentMethod;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Aisel\UserBundle\Entity\User", inversedBy="order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Type("Aisel\UserBundle\Entity\User")
     * @JMS\MaxDepth(1)
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $user;

    /**
     * @var Invoice
     * @ORM\ManyToOne(targetEntity="Aisel\OrderBundle\Entity\Invoice", inversedBy="order")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\OrderBundle\Entity\Invoice")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $invoice;

    /**
     * @var OrderItem
     * @ORM\OneToMany(targetEntity="Aisel\OrderBundle\Entity\OrderItem", mappedBy="order", cascade={"remove"})
     * @JMS\Type("ArrayCollection<Aisel\OrderBundle\Entity\OrderItem>")
     * @JMS\Expose
     * @JMS\MaxDepth(6)
     * @JMS\Groups({"collection","details"})
     */
    private $item;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Aisel\UserBundle\Entity\User", inversedBy="node")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="backend_user_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Groups({"collection","details"})
     */
    private $seller;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->item = new ArrayCollection();
    }


    /**
     * Set locale
     *
     * @param  string $locale
     * @return Order
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set status
     *
     * @param  string $status
     * @return Order
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
     * Set user
     *
     * @param  User $user
     * @return Order
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
     * Set invoice
     *
     * @param  Invoice $invoice
     * @return Order
     */
    public function setInvoice(Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Add item
     *
     * @param  OrderItem $item
     * @return Order
     */
    public function addItem(OrderItem $item)
    {
        $this->item[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param OrderItem $item
     */
    public function removeItem(OrderItem $item)
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

    /**
     * Set totalAmount
     *
     * @param  integer $totalAmount
     * @return Order
     */
    public function setTotalAmount($totalamount)
    {
        $this->totalAmount = $totalamount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return integer
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set currency
     *
     * @param  string $currency
     * @return Order
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set country
     *
     * @param  string $country
     * @return Order
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param  string $region
     * @return Order
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param  string $city
     * @return Order
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param  string $phone
     * @return Order
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set paymentMethod
     *
     * @param  string $paymentMethod
     * @return Order
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return User
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param User $seller
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;
    }

}

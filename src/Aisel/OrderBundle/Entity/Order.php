<?php

namespace Aisel\OrderBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aisel\FrontendUserBundle\Entity\FrontendUser;
use Aisel\ProductBundle\Entity\Product;
use JMS\Serializer\Annotation as JMS;

/**
 * Order
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\OrderBundle\Entity\OrderRepository")
 * @ORM\Table(name="aisel_order")
 * @JMS\ExclusionPolicy("none")
 */
class Order
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false)
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $status = false;

    /**
     * @var float
     * @Assert\NotNull()
     * @ORM\Column(type="float", scale=2, nullable=false)
     * @JMS\Type("float")
     */
    private $totalAmount = 0;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $currency;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $region;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $paymentMethod;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\FrontendUserBundle\Entity\FrontendUser")
     */
    private $frontenduser;

    /**
     * @var Invoice
     * @ORM\ManyToOne(targetEntity="Aisel\OrderBundle\Entity\Invoice", inversedBy="order")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\OrderBundle\Entity\Invoice")
     */
    private $invoice;

    /**
     * @var OrderItem
     * @ORM\OneToMany(targetEntity="Aisel\OrderBundle\Entity\OrderItem", mappedBy="order")
     * @JMS\Type("ArrayCollection<Aisel\OrderBundle\Entity\OrderItem>")
     */
    private $item;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @JMS\Type("DateTime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Type("DateTime")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->item = new ArrayCollection();
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
     * @return Order
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
     * Set description
     *
     * @param  string $description
     * @return Order
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
}

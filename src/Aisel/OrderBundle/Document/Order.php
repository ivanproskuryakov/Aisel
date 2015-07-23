<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Aisel\FrontendUserBundle\Document\FrontendUser;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;

/**
 * Order
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_order",
 *      repositoryClass="Aisel\OrderBundle\Document\OrderRepository"
 * )
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
class Order
{
    use IdTrait;
    use UpdateCreateTrait;
    use LocaleTrait;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     */
    private $status = false;

    /**
     * @var integer
     * @Assert\NotNull()
     * @ODM\Field(type="string")
     * @JMS\Type("integer")
     */
    private $totalAmount = 0;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $currency;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $country;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $region;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $city;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $phone;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     */
    private $paymentMethod;

    /**
     * @var FrontendUser
     * @ODM\ReferenceOne(targetDocument="Aisel\OrderBundle\Document\Order", inversedBy="order")
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\FrontendUserBundle\Document\FrontendUser")
     */
    private $frontenduser;

    /**
     * @var Invoice
     * @ODM\ReferenceOne(targetDocument="Aisel\OrderBundle\Document\Invoice", inversedBy="order")
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\OrderBundle\Document\Invoice")
     */
    private $invoice;

    /**
     * @var OrderItem
     * @ODM\ReferenceMany(targetDocument="Aisel\OrderBundle\Document\OrderItem", mappedBy="order")
     * @JMS\Type("ArrayCollection<Aisel\OrderBundle\Document\OrderItem>")
     */
    private $item;

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

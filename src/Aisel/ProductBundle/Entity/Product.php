<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Entity\UrlInterface;

/**
 * Product
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ProductBundle\Entity\ProductRepository")
 * @ORM\Table(name="aisel_product")
 */
class Product implements UrlInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false)
     * @Assert\NotNull()
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $sku;

    /**
     * @var float
     * @Assert\NotNull()
     * @ORM\Column(type="float", scale=2, nullable=true)
     */
    private $price;

    /**
     * @var float
     * @ORM\Column(type="float", scale=2, nullable=true)
     */
    private $priceSpecial;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $priceSpecialFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $priceSpecialTo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $new = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $newFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $newTo;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $qty = 0;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $inStock = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $manageStock = false;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     */
    private $descriptionShort;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     */
    private $description;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $status = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $hidden = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $commentStatus = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $metaUrl;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $metaTitle;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $metaDescription;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $metaKeywords;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Aisel\ProductBundle\Entity\Image", mappedBy="product", cascade={"remove"})
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Aisel\ProductBundle\Entity\Category")
     * @ORM\JoinTable(
     *     name="aisel_product_product_category",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Entity\Category>")
     */
    private $categories;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getSku();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->simage = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * @param  string  $locale
     * @return Product
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
     * Set name
     *
     * @param  string  $name
     * @return Product
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

    /**
     * Set sku
     *
     * @param  string  $sku
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set price
     *
     * @param  float   $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceSpecial
     *
     * @param  float   $priceSpecial
     * @return Product
     */
    public function setPriceSpecial($priceSpecial)
    {
        $this->priceSpecial = $priceSpecial;

        return $this;
    }

    /**
     * Get priceSpecial
     *
     * @return float
     */
    public function getPriceSpecial()
    {
        return $this->priceSpecial;
    }

    /**
     * Set priceSpecialFrom
     *
     * @param  \DateTime $priceSpecialFrom
     * @return Product
     */
    public function setPriceSpecialFrom($priceSpecialFrom)
    {
        $this->priceSpecialFrom = $priceSpecialFrom;

        return $this;
    }

    /**
     * Get priceSpecialFrom
     *
     * @return \DateTime
     */
    public function getPriceSpecialFrom()
    {
        return $this->priceSpecialFrom;
    }

    /**
     * Set priceSpecialTo
     *
     * @param  \DateTime $priceSpecialTo
     * @return Product
     */
    public function setPriceSpecialTo($priceSpecialTo)
    {
        $this->priceSpecialTo = $priceSpecialTo;

        return $this;
    }

    /**
     * Get priceSpecialTo
     *
     * @return \DateTime
     */
    public function getPriceSpecialTo()
    {
        return $this->priceSpecialTo;
    }

    /**
     * Set new
     *
     * @param  boolean $new
     * @return Product
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return boolean
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set newFrom
     *
     * @param  \DateTime $newFrom
     * @return Product
     */
    public function setNewFrom($newFrom)
    {
        $this->newFrom = $newFrom;

        return $this;
    }

    /**
     * Get newFrom
     *
     * @return \DateTime
     */
    public function getNewFrom()
    {
        return $this->newFrom;
    }

    /**
     * Set newTo
     *
     * @param  \DateTime $newTo
     * @return Product
     */
    public function setNewTo($newTo)
    {
        $this->newTo = $newTo;

        return $this;
    }

    /**
     * Get newTo
     *
     * @return \DateTime
     */
    public function getNewTo()
    {
        return $this->newTo;
    }

    /**
     * Set qty
     *
     * @param  integer $qty
     * @return Product
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
     * Set inStock
     *
     * @param  boolean $inStock
     * @return Product
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;

        return $this;
    }

    /**
     * Get inStock
     *
     * @return boolean
     */
    public function getInStock()
    {
        return $this->inStock;
    }

    /**
     * Set manageStock
     *
     * @param  boolean $manageStock
     * @return Product
     */
    public function setManageStock($manageStock)
    {
        $this->manageStock = $manageStock;

        return $this;
    }

    /**
     * Get manageStock
     *
     * @return boolean
     */
    public function getManageStock()
    {
        return $this->manageStock;
    }

    /**
     * Set descriptionShort
     *
     * @param  string  $descriptionShort
     * @return Product
     */
    public function setDescriptionShort($descriptionShort)
    {
        $this->descriptionShort = $descriptionShort;

        return $this;
    }

    /**
     * Get descriptionShort
     *
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }

    /**
     * Set description
     *
     * @param  string  $description
     * @return Product
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
     * Set status
     *
     * @param  boolean $status
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set hidden
     *
     * @param  boolean $hidden
     * @return Product
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set commentStatus
     *
     * @param  boolean $commentStatus
     * @return Product
     */
    public function setCommentStatus($commentStatus)
    {
        $this->commentStatus = $commentStatus;

        return $this;
    }

    /**
     * Get commentStatus
     *
     * @return boolean
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set metaUrl
     *
     * @param  string  $metaUrl
     * @return Product
     */
    public function setMetaUrl($metaUrl)
    {
        $this->metaUrl = $metaUrl;

        return $this;
    }

    /**
     * Get metaUrl
     *
     * @return string
     */
    public function getMetaUrl()
    {
        return $this->metaUrl;
    }

    /**
     * Set metaTitle
     *
     * @param  string  $metaTitle
     * @return Product
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param  string  $metaDescription
     * @return Product
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param  string  $metaKeywords
     * @return Product
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
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
     * Add image
     *
     * @param  Image   $image
     * @return Product
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get images
     *
     * @return Collection
     */
    public function getMainImage()
    {
        return $this->images;
    }

    /**
     * Add categories
     *
     * @param  Category $categories
     * @return Product
     */
    public function addCategory(Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $categories
     */
    public function removeCategory(Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

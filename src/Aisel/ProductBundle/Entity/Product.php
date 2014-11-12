<?php

namespace Aisel\ProductBundle\Entity;

use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @FileStore\Uploadable
 * Product
 */
class Product
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $priceSpecial;

    /**
     * @var \DateTime
     */
    private $priceSpecialFrom;

    /**
     * @var \DateTime
     */
    private $priceSpecialTo;

    /**
     * @var boolean
     */
    private $new;

    /**
     * @var \DateTime
     */
    private $newFrom;

    /**
     * @var \DateTime
     */
    private $newTo;

    /**
     * @var integer
     */
    private $qty;

    /**
     * @var boolean
     */
    private $inStock;

    /**
     * @var boolean
     */
    private $manageStock;

    /**
     * @var string
     */
    private $descriptionShort;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var boolean
     */
    private $hidden;

    /**
     * @var boolean
     */
    private $commentStatus;

    /**
     * @var string
     */
    private $metaUrl;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var string
     */
    private $metaDescription;

    /**
     * @var string
     */
    private $metaKeywords;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var array
     * @Assert\Image( maxSize="10M")
     * @FileStore\UploadableField(mapping="mainImage")
     */
    private $mainImage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $image;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

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
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Page
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
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Product
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
     * @param  \DateTime $updatedAt
     * @return Product
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
     * Set mainImage
     *
     * @param  array   $mainImage
     * @return Product
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * Get mainImage
     *
     * @return array
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * Add image
     *
     * @param  \Aisel\ProductBundle\Entity\Image $image
     * @return Product
     */
    public function addImage(\Aisel\ProductBundle\Entity\Image $image)
    {
        $this->image[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Aisel\ProductBundle\Entity\Image $image
     */
    public function removeImage(\Aisel\ProductBundle\Entity\Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add categories
     *
     * @param  \Aisel\ProductBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategory(\Aisel\ProductBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Aisel\ProductBundle\Entity\Category $categories
     */
    public function removeCategory(\Aisel\ProductBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

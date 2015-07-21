<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\ProductBundle\Document\Category;
use Aisel\ResourceBundle\Domain\UpdateCreate;
use Aisel\ResourceBundle\Domain\Meta;

/**
 * Product
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_product",
 *      repositoryClass="Aisel\ProductBundle\Document\ProductRepository"
 * )
 */
class Product implements UrlInterface
{
    use UpdateCreate;
    use Meta;

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 2,
     *      max = 2
     * )
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $locale;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $sku;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $price;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $priceSpecial;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $priceSpecialFrom;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $priceSpecialTo;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $new = false;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $newFrom;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $newTo;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("integer")
     */
    private $qty = 0;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $inStock = false;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $manageStock = false;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $descriptionShort;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $hidden = false;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $status = false;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $commentStatus = false;

    /**
     * @var Collection
     * @ODM\ReferenceMany(targetDocument="Aisel\ProductBundle\Document\Image", cascade={"remove"})
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Document\Image>")
     */
    private $images;

    /**
     * @var ArrayCollection
     * @ODM\ReferenceMany(targetDocument="Aisel\PageBundle\Document\Category")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Document\Category>")
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
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
     * @param  Category $category
     * @return Product
     */
    public function addCategory(Category $category)
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
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

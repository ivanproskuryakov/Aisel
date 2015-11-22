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
use Aisel\ProductBundle\Entity\Node;
use Aisel\MediaBundle\Entity\Media;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;
//use Aisel\ReviewBundle\Domain\ReviewTrait;

/**
 * Product
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_product")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Product implements UrlInterface
{

    use IdTrait;
    use UpdateCreateTrait;
    use MetaTrait;
    use StatusTrait;
    use NameTrait;
    use LocaleTrait;
    use QtyTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $sku;

    /**
     * @var string
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("float")
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     * @JMS\Expose
     * @JMS\Type("float")
     */
    private $priceSpecial;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $priceSpecialFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $priceSpecialTo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $new = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $newFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     */
    private $newTo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $inStock = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $manageStock = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $descriptionShort;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $hidden = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $commentStatus = false;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Aisel\MediaBundle\Entity\Media", mappedBy="product", cascade={"remove"})
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\MediaBundle\Entity\Media>")
     * @AiselAnnotation\NoDuplicates()
     */
    private $medias;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Aisel\ProductBundle\Entity\Node")
     * @ORM\JoinTable(
     *     name="aisel_product_product_node",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")}
     * )
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Entity\Node>")
     * @AiselAnnotation\NoDuplicates()
     */
    private $nodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->nodes = new ArrayCollection();
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
     * Set medias
     *
     * @param  ArrayCollection   $medias
     * @return Product
     */
    public function setMedias(ArrayCollection $medias)
    {
        $this->medias = $medias;

        return $this;
    }

    /**
     * Add media
     *
     * @param  Media   $media
     * @return Product
     */
    public function addMedia(Media $media)
    {
        $this->medias[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param Media $media
     */
    public function removeMedia(Media $media)
    {
        $this->medias->removeElement($media);
    }

    /**
     * Get medias
     *
     * @return Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Get medias
     *
     * @return Collection
     */
    public function getMainMedia()
    {
        return $this->medias;
    }

    /**
     * Add nodes$
     *
     * @param  Node $node
     * @return Product
     */
    public function addNode(Node $node)
    {
        $this->nodes->add($node);

        return $this;
    }

    /**
     * Remove nodes
     *
     * @param Node $node
     */
    public function removeNode(Node $node)
    {
        $this->nodes->removeElement($node);
    }

    /**
     * Get nodes
     *
     * @return Collection
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}

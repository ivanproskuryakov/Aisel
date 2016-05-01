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

use Aisel\MediaBundle\Entity\Media;
use Aisel\ProductBundle\Entity\Node;
use Aisel\ProductBundle\Entity\Review;
use Aisel\ResourceBundle\Domain\CommentStatusTrait;
use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\QtyTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;

use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\UrlInterface;
use Aisel\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

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
    use LocaleTrait;
    use StatusTrait;
    use QtyTrait;
    use NameTrait;
    use ContentTrait;
    use MetaTrait;
    use CommentStatusTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $sku;

    /**
     * @var string
     * @ORM\Column(type="float", scale=2, nullable=true)
     * @Assert\Type(type="float")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("float")
     * @JMS\Groups({"collection","details"})
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="float", scale=2, nullable=true)
     * @Assert\Type(type="float")
     * @JMS\Expose
     * @JMS\Type("float")
     * @JMS\Groups({"collection","details"})
     */
    private $priceSpecial;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    private $priceSpecialFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    private $priceSpecialTo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\Groups({"collection","details"})
     */
    private $new = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    private $newFrom;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Groups({"collection","details"})
     */
    private $newTo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\Groups({"collection","details"})
     */
    private $inStock = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\Groups({"collection","details"})
     */
    private $manageStock = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $descriptionShort;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\Groups({"collection","details"})
     */
    private $hidden = false;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Aisel\MediaBundle\Entity\Media", cascade="remove")
     * @ORM\JoinTable(
     *     name="aisel_product_product_media",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="cascade")}
     * )
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Type("ArrayCollection<Aisel\MediaBundle\Entity\Media>")
     * @JMS\Groups({"collection","details"})
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
     * @JMS\MaxDepth(2)
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Entity\Node>")
     * @JMS\Groups({"collection","details"})
     */
    private $nodes;

    /**
     * @var ArrayCollection<Aisel\ProductBundle\Entity\Review>
     * @ORM\OneToMany(targetEntity="Aisel\ProductBundle\Entity\Review", mappedBy="subject", cascade={"all"})
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Entity\Review>")
     * @JMS\Groups({"collection","details"})
     */
    private $reviews;

    /**
     * @var User
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Aisel\UserBundle\Entity\User", inversedBy="product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="backend_user_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Expose
     * @JMS\Readonly
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\UserBundle\Entity\User")
     * @JMS\Groups({"collection","details"})
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->nodes = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    /**
     * Set sku
     *
     * @param  string $sku
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
     * @param  float $price
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
     * @param  float $priceSpecial
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
     * @param  string $descriptionShort
     * @return Product
     */
    public function setContentShort($descriptionShort)
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
     * Set medias
     *
     * @param  ArrayCollection $medias
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
     * @param  Media $media
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

    /**
     * @return ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param ArrayCollection $reviews
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * Add review
     *
     * @param Review $review
     *
     * @return Product
     */
    public function addReview(Review $review)
    {
        $this->reviews->add($review);

        return $this;
    }


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Entity;

use Aisel\PageBundle\Entity\Node;
use Aisel\PageBundle\Entity\Review;
use Aisel\ResourceBundle\Domain\CommentStatusTrait;
use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;

use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\UrlInterface;
use Aisel\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_page")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */

class Page implements UrlInterface
{
    use IdTrait;
    use NameTrait;
    use ContentTrait;
    use LocaleTrait;
    use StatusTrait;
    use CommentStatusTrait;
    use MetaTrait;
    use UpdateCreateTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Aisel\PageBundle\Entity\Node")
     * @ORM\JoinTable(
     *     name="aisel_page_page_node",
     *     joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")}
     * )
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Entity\Node>")
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Groups({"collection","details"})
     */
    private $nodes;

    /**
     * @var ArrayCollection<Aisel\PageBundle\Entity\Review>
     * @ORM\OneToMany(targetEntity="Aisel\PageBundle\Entity\Review", mappedBy="subject", cascade={"all"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Entity\Review>")
     * @JMS\Groups({"collection","details"})
     */
    private $reviews;

    /**
     *
     * @var User
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Aisel\UserBundle\Entity\User", inversedBy="page")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
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
        $this->reviews = new ArrayCollection();
        $this->nodes = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add node
     *
     * @param Node $node
     *
     * @return Page
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
     * @return ArrayCollection
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Get nodes
     *
     * @param Node $nodes
     *
     * @return Page
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
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
     * @return Page
     */
    public function addReview($review)
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
    public function setUser($user)
    {
        $this->user = $user;
    }


}

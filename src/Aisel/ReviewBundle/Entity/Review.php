<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Aisel\ReviewBundle\Entity\Node;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Aisel\ResourceBundle\Domain\ContentTrait;

/**
 * Review
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_review")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Review
{

    use IdTrait;
    use TitleTrait;
    use UpdateCreateTrait;
    use LocaleTrait;
    use StatusTrait;
    use ContentTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Aisel\ReviewBundle\Entity\Node")
     * @ORM\JoinTable(
     *     name="aisel_review_review_node",
     *     joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")}
     * )
     * @JMS\Type("ArrayCollection<Aisel\ReviewBundle\Entity\Node>")
     * @JMS\Expose
     */
    private $nodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }

    /**
     * Add node
     *
     * @param Node $node
     *
     * @return Review
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
     * @return Review
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
    }
}

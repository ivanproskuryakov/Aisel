<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NodeBundle\Entity;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;

use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
abstract class Node implements NodeInterface
{

    use IdTrait;
    use NameTrait;
    use LocaleTrait;
    use StatusTrait;
    use UpdateCreateTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Aisel\NodeBundle\Entity\Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\NodeBundle\Entity\Node")
     * @JMS\Groups({"collection","details"})
     */
    protected $parent = null;

    /**
     * @ORM\OneToMany(targetEntity="Aisel\NodeBundle\Entity\Node", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Aisel\NodeBundle\Entity\Node>")
     * @JMS\Groups({"collection","details"})
     */
    protected $children = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Add children
     *
     * @param  Node $children
     * @return Node
     */
    public function addChild($children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Node $children
     */
    public function removeChild($children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param  Node $parent
     * @return Node
     */
    public function setParent($parent = null)
    {
        if ($this->parent) {
            $this->parent->removeChild($this);
        }

        $this->parent = $parent;
        $this->parent->addChild($this);

        return $this;
    }

    /**
     * Get parent
     *
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

}

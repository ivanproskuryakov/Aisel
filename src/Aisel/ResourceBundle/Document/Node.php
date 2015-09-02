<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Document\NodeInterface;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
abstract class Node implements NodeInterface
{

    use UpdateCreateTrait;
    use LocaleTrait;
    use StatusTrait;

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     * @JMS\Expose
     */
    protected $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @ODM\ReferenceOne(targetDocument="Aisel\ResourceBundle\Document\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\ResourceBundle\Document\Node")
     */
    protected $parent = null;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\ResourceBundle\Document\Node", mappedBy="parent")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Aisel\ResourceBundle\Document\Node>")
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
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return Node
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
        $this->parent = $parent;

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

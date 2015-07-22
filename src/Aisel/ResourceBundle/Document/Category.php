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
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Category
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @Gedmo\Tree(type="materializedPath")
 * @ODM\HasLifecycleCallbacks()
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
abstract class Category
{

    use UpdateCreateTrait;
    use LocaleTrait;

    /**
     * @var string
     * @ODM\Id
     * @Gedmo\TreePathSource
     * @JMS\Type("string")
     * @JMS\Expose
     */
    protected $id;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $status = false;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Gedmo\TreePath(separator="|")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $path;

    /**
     * @var int
     * @Gedmo\TreeLevel
     * @ODM\Field(type="int")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("int")
     */
    private $lvl;

    /**
     * @Gedmo\TreeParent
     * @ODM\ReferenceOne(targetDocument="Aisel\ResourceBundle\Document\Category", inversedBy="children")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\ResourceBundle\Document\Category")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\ResourceBundle\Document\Category", mappedBy="parent")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Aisel\ResourceBundle\Entity\Category>")
     */
    protected $children;

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
     * @param  string   $title
     * @return Category
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
     * Set lvl
     *
     * @param  integer  $lvl
     * @return Category
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set status
     *
     * @param  boolean  $status
     * @return Category
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
     * Add children
     *
     * @param  Category $children
     * @return Category
     */
    public function addChild(Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Category $children
     */
    public function removeChild(Category $children)
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
     * @param  Category $parent
     * @return Category
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }
}

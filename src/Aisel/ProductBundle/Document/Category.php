<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Document;

use Aisel\ResourceBundle\Document\Category as BaseCategory;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;

/**
 * Category
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_product_category",
 *      repositoryClass="Aisel\ProductBundle\Document\CategoryRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 */
class Category extends BaseCategory implements UrlInterface
{
    use MetaTrait;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @Gedmo\TreeParent
     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Document\Category", inversedBy="children")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("Aisel\ProductBundle\Document\Category")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\ProductBundle\Document\Category")
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Document\Category>")
     */
    protected $children;

    
    /**
     * Set description
     *
     * @param  string   $description
     * @return Category
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

}

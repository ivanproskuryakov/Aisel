<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Document;

use Aisel\ResourceBundle\Document\Node as BaseNode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_page_node",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 */
//* @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})
class Node extends BaseNode implements UrlInterface
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
     * @ODM\ReferenceOne(targetDocument="Aisel\PageBundle\Document\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\Type("Aisel\PageBundle\Document\Node")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\PageBundle\Document\Node")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Document\Node>")
     * @AiselAnnotation\CleanDuplicates()
     */
    protected $children;

    /**
     * Set description
     *
     * @param  string   $description
     * @return Node
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

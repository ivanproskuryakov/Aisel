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

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\PageBundle\Document\Node;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Aisel\ReviewBundle\Domain\ReviewTrait;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

/**
 * Page
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ODM\Entity(
 *      table="aisel_page",
 *      repositoryClass="Aisel\PageBundle\Document\PageRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 * @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})
 *
 */
class Page implements UrlInterface
{
    use IdTrait;
    use TitleTrait;
    use UpdateCreateTrait;
    use LocaleTrait;
    use StatusTrait;
    use MetaTrait;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $content;

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
     * @var ArrayCollection
     * @ODM\ReferenceMany(targetDocument="Aisel\PageBundle\Document\Node")
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Document\Node>")
     * @JMS\Expose
     * @AiselAnnotation\NoDuplicates()
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
     * Set content
     *
     * @param  string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set commentStatus
     *
     * @param  boolean $commentStatus
     * @return Page
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
}

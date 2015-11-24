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

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Entity\UrlInterface;
use Aisel\PageBundle\Entity\Node;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\ResourceBundle\Domain\CommentStatusTrait;
use Aisel\ReviewBundle\Domain\ReviewTrait;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

/**
 * Page
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_page")
 * @ORM\Entity(repositoryClass="Aisel\PageBundle\Entity\PageRepository")
 * @JMS\ExclusionPolicy("all")
 */
//* @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})

class Page implements UrlInterface
{
    use IdTrait;
    use TitleTrait;
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

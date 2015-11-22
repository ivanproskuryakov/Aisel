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

use Aisel\ResourceBundle\Entity\Node as BaseNode;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Entity\UrlInterface;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

use Aisel\ResourceBundle\Domain\DescriptionTrait;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_page_node")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
//* @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})
class Node extends BaseNode implements UrlInterface
{

    use MetaTrait;
    use DescriptionTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Aisel\PageBundle\Entity\Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @JMS\Expose
     * @JMS\Type("Aisel\PageBundle\Entity\Node")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Aisel\PageBundle\Entity\Node", mappedBy="parent")
     * @ORM\OrderBy({"title" = "ASC"})
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Entity\Node>")
     * @AiselAnnotation\NoDuplicates()
     */
    protected $children;


}

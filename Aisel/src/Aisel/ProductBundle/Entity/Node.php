<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Entity;

use Aisel\NodeBundle\Entity\Node as BaseNode;
use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Domain\UrlInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_product_node")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Node extends BaseNode implements UrlInterface
{
    
    use ContentTrait;
    use MetaTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @JMS\Expose
     * @JMS\Type("Aisel\ProductBundle\Entity\Node")
     * @JMS\Groups({"collection","details"})
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Aisel\ProductBundle\Entity\Node", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Entity\Node>")
     * @JMS\Groups({"collection","details"})
     */
    protected $children;

}

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

use Aisel\ResourceBundle\Document\Node as BaseNode;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;

use Aisel\ResourceBundle\Domain\DescriptionTrait;
use Aisel\ResourceBundle\Domain\MetaTrait;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ODM\Entity(
 *      table="aisel_product_node",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 */
class Node extends BaseNode implements UrlInterface
{
    use DescriptionTrait;
    use MetaTrait;

    /**
     * @ODM\ReferenceOne(targetDocument="Aisel\ProductBundle\Document\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\Type("Aisel\ProductBundle\Document\Node")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\ProductBundle\Document\Node")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ProductBundle\Document\Node>")
     */
    protected $children;

}

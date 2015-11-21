<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Document;

use Aisel\ResourceBundle\Document\Node as BaseNode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

use Aisel\ResourceBundle\Domain\DescriptionTrait;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_review_node",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 */
class Node extends BaseNode
{
    use DescriptionTrait;

    /**
     * @ODM\ReferenceOne(targetDocument="Aisel\ReviewBundle\Document\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\Type("Aisel\ReviewBundle\Document\Node")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(cascade="remove", targetDocument="Aisel\ReviewBundle\Document\Node")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\ReviewBundle\Document\Node>")
     * @AiselAnnotation\NoDuplicates()
     */
    protected $children;

}

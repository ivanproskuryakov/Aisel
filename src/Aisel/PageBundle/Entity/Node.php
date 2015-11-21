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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\ResourceBundle\Domain\MetaTrait;
use Aisel\ResourceBundle\Annotation as AiselAnnotation;

use Aisel\ResourceBundle\Domain\DescriptionTrait;

/**
 * Node
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ODM\Entity(
 *      table="aisel_page_node",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 * @JMS\ExclusionPolicy("all")
 */
//* @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})
class Node extends BaseNode implements UrlInterface
{

    use MetaTrait;
    use DescriptionTrait;

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
     * @AiselAnnotation\NoDuplicates()
     */
    protected $children;


}

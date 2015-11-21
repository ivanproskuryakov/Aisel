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
     * @ODM\ReferenceOne(targetDocument="Aisel\PageBundle\Entity\Node", inversedBy="children")
     * @JMS\Expose
     * @JMS\Type("Aisel\PageBundle\Entity\Node")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\PageBundle\Entity\Node")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\PageBundle\Entity\Node>")
     * @AiselAnnotation\NoDuplicates()
     */
    protected $children;


}

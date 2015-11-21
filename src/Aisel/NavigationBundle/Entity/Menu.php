<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Aisel\ResourceBundle\Entity\Node as BaseNode;
use JMS\Serializer\Annotation as JMS;

/**
 * Menu
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(
 *      table="aisel_navigation_menu",
 *      repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository"
 * )
 */
class Menu extends BaseNode
{

    /**
     * @ODM\ReferenceOne(targetDocument="Aisel\NavigationBundle\Entity\Menu")
     * @JMS\Expose
     * @JMS\Type("Aisel\NavigationBundle\Entity\Menu")
     */
    protected $parent;

    /**
     * @ODM\ReferenceMany(targetDocument="Aisel\NavigationBundle\Entity\Menu")
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\NavigationBundle\Entity\Menu>")
     */
    protected $children;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $metaUrl;

    /**
     * Set metaUrl
     *
     * @param  string $metaUrl
     * @return Menu
     */
    public function setMetaUrl($metaUrl)
    {
        $this->metaUrl = $metaUrl;

        return $this;
    }

    /**
     * Get metaUrl
     *
     * @return string
     */
    public function getMetaUrl()
    {
        return $this->metaUrl;
    }

}

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

use Aisel\NodeBundle\Entity\Node as BaseNode;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menu
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_navigation_menu")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 */
class Menu extends BaseNode
{

    /**
     * @ORM\ManyToOne(targetEntity="Aisel\NavigationBundle\Entity\Menu", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Type("Aisel\NavigationBundle\Entity\Menu")
     * @JMS\Groups({"collection","details"})
     */
    protected $parent = null;

    /**
     * @ORM\OneToMany(targetEntity="Aisel\NavigationBundle\Entity\Menu", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     * @JMS\Type("ArrayCollection<Aisel\NavigationBundle\Entity\Menu>")
     * @JMS\Groups({"collection","details"})
     */
    protected $children = null;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
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

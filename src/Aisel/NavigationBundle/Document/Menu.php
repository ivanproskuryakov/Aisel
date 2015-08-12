<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Aisel\ResourceBundle\Document\Category as BaseCategory;
use JMS\Serializer\Annotation as JMS;

/**
 * Menu
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_navigation_menu",
 *      repositoryClass="Aisel\NavigationBundle\Document\MenuRepository"
 * )
 */
class Menu extends BaseCategory
{

    /**
     * @var string
     * @ODM\Field(type="string")
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

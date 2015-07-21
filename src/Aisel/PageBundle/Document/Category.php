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

use Aisel\ResourceBundle\Document\Category as BaseCategory;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Document\UrlInterface;
use Aisel\ResourceBundle\Domain\Meta;

/**
 * Category
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_page_category",
 *      repositoryClass="Aisel\PageBundle\Document\CategoryRepository"
 * )
 * @ODM\UniqueIndex(keys={"locale"="asc", "metaUrl"="asc"})
 */
class Category extends BaseCategory implements UrlInterface
{

    use Meta;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $description;


    /**
     * Set description
     *
     * @param  string   $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}

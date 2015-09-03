<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Image
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_media_image"
 * )
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
class Image
{

    use IdTrait;
    use TitleTrait;
    use UpdateCreateTrait;

    /**
     * @var boolean
     * @Assert\Type(type="bool")
     * @ODM\Field(type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $mainImage = false;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $filename;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * Set filename
     *
     * @param  string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return boolean
     */
    public function isMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param boolean $mainImage
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }

}

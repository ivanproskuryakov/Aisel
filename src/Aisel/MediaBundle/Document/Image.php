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
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Image
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="media_image"
 * )
 * @ODM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
class Image
{

    use UpdateCreateTrait;

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

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
    protected $title;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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

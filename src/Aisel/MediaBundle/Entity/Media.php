<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\MediaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\TitleTrait;
use Aisel\ResourceBundle\Domain\DescriptionTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Media
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 * @ORM\Table(name="aisel_media")
 * @JMS\ExclusionPolicy("all")
 */
class Media
{

    use IdTrait;
    use DescriptionTrait;
    use TitleTrait;
    use UpdateCreateTrait;

    /**
     * @var boolean
     * @Assert\Type(type="bool")
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $mainImage = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $filename;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $type;

    /**
     * Set filename
     *
     * @param  string $filename
     * @return Media
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

    /**
     * Gets Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Entity;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Country
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @ORM\Table(name="aisel_addressing_country")
 */
class Country
{

    use IdTrait;
    use StatusTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $iso2;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $iso3;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $shortName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $longName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $numcode;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     * @JMS\Type("boolean")
     * @JMS\Groups({"collection","details"})
     */
    private $unMember = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $callingCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $cctld;

    /**
     * @var ArrayCollection<Aisel\AddressingBundle\Entity\Region>
     * @ORM\OneToMany(targetEntity="Aisel\AddressingBundle\Entity\Region", mappedBy="country", cascade={"remove"})
     * @JMS\Expose
     * @JMS\MaxDepth(1)
     * @JMS\Type("ArrayCollection<Aisel\AddressingBundle\Entity\Region>")
     * @JMS\Groups({"collection","details"})
     */
    private $regions;

    public function __toString()
    {
        return $this->getLongName();
    }

    /**
     * Set iso2
     *
     * @param  string  $iso2
     * @return Country
     */
    public function setIso2($iso2)
    {
        $this->iso2 = $iso2;

        return $this;
    }

    /**
     * Get iso2
     *
     * @return string
     */
    public function getIso2()
    {
        return $this->iso2;
    }

    /**
     * Set iso3
     *
     * @param  string  $iso3
     * @return Country
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;

        return $this;
    }

    /**
     * Get iso3
     *
     * @return string
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * Set shortName
     *
     * @param  string  $shortName
     * @return Country
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set longName
     *
     * @param  string  $longName
     * @return Country
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * Get longName
     *
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Set numcode
     *
     * @param  string  $numcode
     * @return Country
     */
    public function setNumcode($numcode)
    {
        $this->numcode = $numcode;

        return $this;
    }

    /**
     * Get numcode
     *
     * @return string
     */
    public function getNumcode()
    {
        return $this->numcode;
    }

    /**
     * Set unMember
     *
     * @param  boolean $unMember
     * @return Country
     */
    public function setUnMember($unMember)
    {
        $this->unMember = $unMember;

        return $this;
    }

    /**
     * Get unMember
     *
     * @return boolean
     */
    public function getUnMember()
    {
        return $this->unMember;
    }

    /**
     * Set callingCode
     *
     * @param  string  $callingCode
     * @return Country
     */
    public function setCallingCode($callingCode)
    {
        $this->callingCode = $callingCode;

        return $this;
    }

    /**
     * Get callingCode
     *
     * @return string
     */
    public function getCallingCode()
    {
        return $this->callingCode;
    }

    /**
     * Set cctld
     *
     * @param  string  $cctld
     * @return Country
     */
    public function setCctld($cctld)
    {
        $this->cctld = $cctld;

        return $this;
    }

    /**
     * Get cctld
     *
     * @return string
     */
    public function getCctld()
    {
        return $this->cctld;
    }

    /**
     * @return ArrayCollection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param ArrayCollection $regions
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;
    }


}
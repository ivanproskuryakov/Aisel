<?php

namespace Aisel\AddressingBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\AddressingBundle\Entity\CountryRepository")
 * @ORM\Table(name="aisel_addressing_country")
 */
class Country
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=2)
     * @Assert\Type(type="string")
     */
    private $iso2;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     * @Assert\Type(type="string")
     */
    private $iso3;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $shortName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $longName;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     * @Assert\Type(type="string")
     */
    private $numcode;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $unMember;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     * @Assert\Type(type="string")
     */
    private $callingCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     * @Assert\Type(type="string")
     */
    private $cctld;

    public function __toString()
    {
        return $this->getShortName();
    }

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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

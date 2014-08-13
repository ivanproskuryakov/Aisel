<?php

namespace Aisel\AddressingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 */
class Country
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $iso2;

    /**
     * @var string
     */
    private $iso3;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @var string
     */
    private $longName;

    /**
     * @var string
     */
    private $numcode;

    /**
     * @var boolean
     */
    private $unMember;

    /**
     * @var string
     */
    private $callingCode;

    /**
     * @var string
     */
    private $cctld;


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
     * @param string $iso2
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
     * @param string $iso3
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
     * @param string $shortName
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
     * @param string $longName
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
     * @param string $numcode
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
     * @param boolean $unMember
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
     * @param string $callingCode
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
     * @param string $cctld
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Country
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Country
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

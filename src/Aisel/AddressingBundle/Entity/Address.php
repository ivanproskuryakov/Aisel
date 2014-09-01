<?php

namespace Aisel\AddressingBundle\Entity;

/**
 * Address
 */
class Address
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $address;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Aisel\FrontendUserBundle\Entity\FrontendUser
     */
    private $frontenduser;

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
     * Set address
     *
     * @param  string  $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Address
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
     * @param  \DateTime $updatedAt
     * @return Address
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

    /**
     * Set frontenduser
     *
     * @param  \Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser
     * @return Address
     */
    public function setFrontenduser(\Aisel\FrontendUserBundle\Entity\FrontendUser $frontenduser = null)
    {
        $this->frontenduser = $frontenduser;

        return $this;
    }

    /**
     * Get frontenduser
     *
     * @return \Aisel\FrontendUserBundle\Entity\FrontendUser
     */
    public function getFrontenduser()
    {
        return $this->frontenduser;
    }
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var \Aisel\AddressingBundle\Entity\Country
     */
    private $country;

    /**
     * Set street
     *
     * @param  string  $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param  string  $zip
     * @return Address
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set country
     *
     * @param  \Aisel\AddressingBundle\Entity\Country $country
     * @return Address
     */
    public function setCountry(\Aisel\AddressingBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Aisel\AddressingBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * @var \Aisel\AddressingBundle\Entity\Region
     */
    private $region;

    /**
     * Set region
     *
     * @param  \Aisel\AddressingBundle\Entity\Region $region
     * @return Address
     */
    public function setRegion(\Aisel\AddressingBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Aisel\AddressingBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }
    /**
     * @var \Aisel\AddressingBundle\Entity\City
     */
    private $city;

    /**
     * Set city
     *
     * @param  \Aisel\AddressingBundle\Entity\City $city
     * @return Address
     */
    public function setCity(\Aisel\AddressingBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Aisel\AddressingBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $comment;

    /**
     * Set phone
     *
     * @param  string  $phone
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set comment
     *
     * @param  string  $comment
     * @return Address
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @var integer
     */
    private $fixtureId;


    /**
     * Set fixtureId
     *
     * @param integer $fixtureId
     * @return Address
     */
    public function setFixtureId($fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this;
    }

    /**
     * Get fixtureId
     *
     * @return integer 
     */
    public function getFixtureId()
    {
        return $this->fixtureId;
    }
}

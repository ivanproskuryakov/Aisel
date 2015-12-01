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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Aisel\FrontendUserBundle\Entity\FrontendUser;
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Address
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @ORM\Table(name="aisel_addressing_address")
 */
class Address
{

    use IdTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $street;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $comment;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     * @JMS\Type("string")
     */
    private $zip;

    /**
     * @var City
     * @ORM\OneToOne(targetEntity="Aisel\AddressingBundle\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var Region
     * @ORM\OneToOne(targetEntity="Aisel\AddressingBundle\Entity\Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var Country
     * @ORM\OneToOne(targetEntity="Aisel\AddressingBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @var FrontendUser
     * @ORM\ManyToOne(targetEntity="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="addresses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $frontenduser;

    /**
     * Set frontenduser
     *
     * @param  FrontendUser $frontenduser
     * @return Address
     */
    public function setFrontenduser(FrontendUser $frontenduser = null)
    {
        $this->frontenduser = $frontenduser;

        return $this;
    }

    /**
     * Get frontenduser
     *
     * @return FrontendUser
     */
    public function getFrontenduser()
    {
        return $this->frontenduser;
    }

    /**
     * Set street
     *
     * @param  string $street
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
     * @param  string $zip
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
     * @param  Country $country
     * @return Address
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param  Region $region
     * @return Address
     */
    public function setRegion(Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param  City $city
     * @return Address
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param  string $phone
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
     * @param  string $comment
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
}

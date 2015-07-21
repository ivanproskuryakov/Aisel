<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;
use Aisel\ResourceBundle\Domain\UpdateCreate;

/**
 * Country
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_addressing_country",
 *      repositoryClass="Aisel\AddressingBundle\Document\CountryRepository"
 * )
 */
class Country
{

    use UpdateCreate;

    /**
     * @var string
     * @ODM\Id
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $iso2;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $iso3;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $shortName;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $longName;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $numcode;

    /**
     * @var boolean
     * @ODM\Field(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $unMember = false;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     */
    private $callingCode;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     */
    private $cctld;


    /**
     * Get id
     *
     * @return string
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

}

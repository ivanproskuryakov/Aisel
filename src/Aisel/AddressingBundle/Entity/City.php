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
use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\NameTrait;

/**
 * City
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @ORM\Table(name="aisel_addressing_city")
 */
class City
{

    use IdTrait;
    use NameTrait;
    use UpdateCreateTrait;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="Aisel\AddressingBundle\Entity\Region", inversedBy="cities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     * @JMS\Type("Aisel\AddressingBundle\Entity\Region")
     *
     */
    private $region;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Aisel\AddressingBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     * @JMS\Type("Aisel\AddressingBundle\Entity\Country")
     */
    private $country;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set country
     *
     * @param  Country $country
     * @return City
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
     * @return City
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

}

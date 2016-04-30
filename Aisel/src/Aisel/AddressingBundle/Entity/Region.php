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
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Region
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @ORM\Table(name="aisel_addressing_region")
 * @JMS\ExclusionPolicy("all")
 */
class Region
{

    use IdTrait;
    use NameTrait;
    use StatusTrait;
    use UpdateCreateTrait;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Aisel\AddressingBundle\Entity\Country", inversedBy="regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     * @JMS\Type("Aisel\AddressingBundle\Entity\Country")
     * @JMS\Expose
     */
    private $country;

    /**
     * @var ArrayCollection<Aisel\AddressingBundle\Entity\City>
     * @ORM\OneToMany(targetEntity="Aisel\AddressingBundle\Entity\City", mappedBy="region", cascade={"remove"})
     * @JMS\Expose
     * @JMS\Type("ArrayCollection<Aisel\AddressingBundle\Entity\City>")
     */
    private $cities;

    /**
     * Set country
     *
     * @param  Country $country
     * @return Region
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
     * @return ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @param ArrayCollection $cities
     */
    public function setCities($cities)
    {
        $this->cities = $cities;
    }


}

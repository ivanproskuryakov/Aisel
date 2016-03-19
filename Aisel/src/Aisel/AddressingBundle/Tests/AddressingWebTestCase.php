<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Tests;

use Aisel\AddressingBundle\Entity\City;
use Aisel\AddressingBundle\Entity\Country;
use Aisel\AddressingBundle\Entity\Region;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * AddressingWebTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class AddressingWebTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * newCountry
     *
     * @return Country $country
     */
    public function newCountry()
    {
        $country = new Country();
        $country->setIso2($this->faker->countryCode);
        $country->setIso3($this->faker->countryISOAlpha3);
        $country->setShortName($this->faker->country);
        $country->setLongName($this->faker->country);
        $country->setNumcode($this->faker->numberBetween());
        $country->setCallingCode($this->faker->numberBetween());
        $country->setCctld($this->faker->domainWord);
        $country->setStatus(true);

        $this->em->persist($country);
        $this->em->flush();

        return $country;
    }

    /**
     * newRegion
     *
     * @return Region $region
     */
    public function newRegion()
    {
        $country = $this->newCountry();
        $region = new Region();
        $region->setName($this->faker->city);
        $region->setCountry($country);
        $region->setStatus(true);

        $this->em->persist($region);
        $this->em->flush();

        return $region;
    }

    /**
     * newCity
     *
     * @return City $region
     */
    public function newCity()
    {
        $region = $this->newRegion();

        $city = new City();
        $city->setName($this->faker->city);
        $city->setRegion($region);
        $city->setStatus(true);

        $this->em->persist($city);
        $this->em->flush();

        return $city;
    }


}

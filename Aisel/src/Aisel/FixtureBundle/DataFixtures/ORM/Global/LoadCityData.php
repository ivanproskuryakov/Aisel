<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM;

use Aisel\AddressingBundle\Entity\City;
use Aisel\FixtureBundle\Model\XMLFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * City fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadCityData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_city.xml');

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);
                $city = null;

                foreach ($XML->database->table as $table) {
                    $region = $this->getReference('region_' . $table->column[3]); // City of Madrid

                    $city = new City();
                    $city->setName($table->column[1]);
                    $city->setStatus($table->column[2]);
                    $city->setRegion($region);
                    $manager->persist($city);
                    $manager->flush();
                }
                $this->addReference('city_' . $table->column[0], $city);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 530;
    }
}

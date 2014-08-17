<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Aisel\ResourceBundle\DataFixtures\ORM\AbstractFixtureData;
use Aisel\AddressingBundle\Entity\City;

/**
 * City fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCityData extends AbstractFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_city.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Hardcoded references
        $country = $this->getReference('country');
        $region = $this->getReference('region');

        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);
            $city = null;

            foreach ($XML->database->table as $table) {
                $city = new City();
                $city->setName($table->column[1]);
                $city->setRegion($region);
                $city->setCountry($country);
                $city->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $city->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($city);
                $manager->flush();
            }
            $this->addReference('city', $city);
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

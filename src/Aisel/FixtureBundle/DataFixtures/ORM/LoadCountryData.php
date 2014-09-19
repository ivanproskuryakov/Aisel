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

use Aisel\FixtureBundle\DataFixtures\XMLFixtureData;
use Aisel\AddressingBundle\Entity\Country;

/**
 * Country fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCountryData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_country.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            foreach ($XML->database->table as $table) {
                $country = new Country();
                $country->setIso2($table->column[1]);
                $country->setIso3($table->column[2]);
                $country->setShortName($table->column[3]);
                $country->setLongName($table->column[4]);
                $country->setNumcode($table->column[5]);
                $country->setUnMember($table->column[6]);
                $country->setCallingCode($table->column[7]);
                $country->setCctld($table->column[8]);
                $country->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $country->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($country);
                $manager->flush();
                $this->addReference('country_' . $table->column[0], $country);
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 510;
    }
}

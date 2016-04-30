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

use Aisel\AddressingBundle\Entity\Country;
use Aisel\FixtureBundle\Model\XMLFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Country fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadCountryData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_country.xml');

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
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
                    $country->setStatus(true);
                    $manager->persist($country);
                    $manager->flush();
                    $this->addReference('country_' . $table->column[0], $country);
                }
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

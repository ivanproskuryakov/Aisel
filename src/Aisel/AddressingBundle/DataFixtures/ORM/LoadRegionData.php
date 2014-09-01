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
use Aisel\AddressingBundle\Entity\Region;

/**
 * Region fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadRegionData extends AbstractFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_region.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);
            $region = null;

            foreach ($XML->database->table as $table) {
                $country = $this->getReference('country_' . $table->column[4]); // Spain

                $region = new Region();
                $region->setName($table->column[1]);
                $region->setCountry($country);
                $region->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $region->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($region);
                $manager->flush();
            }
            $this->addReference('region_' . $table->column[0], $region);
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 520;
    }
}

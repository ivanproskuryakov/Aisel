<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\AddressingBundle\Entity\Address;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadAddressData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array('global/aisel_address.xml');

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);
                $address = null;

                foreach ($XML->database->table as $table) {
                    $country = $this->getReference('country_' . $table->column[1]); // Spain
                    $region = $this->getReference('region_' . $table->column[2]); // City of Madrid
                    $city = $this->getReference('city_' . $table->column[3]); // Madrid
                    $frontendUser = $this->getReference('frontenduser_' . $table->column[4]); // FrontendUser

                    $address = new Address();
                    $address->setPhone($table->column[5]);
                    $address->setStreet($table->column[6]);
                    $address->setZip($table->column[7]);
                    $address->setComment($table->column[8]);
                    $address->setFrontenduser($frontendUser);
                    $address->setCountry($country);
                    $address->setRegion($region);
                    $address->setCity($city);
                    $address->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                    $address->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                    $manager->persist($address);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 540;
    }
}

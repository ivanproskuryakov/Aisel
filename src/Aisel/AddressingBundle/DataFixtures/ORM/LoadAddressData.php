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
use Aisel\AddressingBundle\Entity\Address;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadAddressData extends AbstractFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_address.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Hardcoded references
        $frontendUser = $this->getReference('frontenduser');
        $country = $this->getReference('country');
        $region = $this->getReference('region');
        $city = $this->getReference('city');

        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);
            $address = null;

            foreach ($XML->database->table as $table) {
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
            $this->addReference('address', $address);

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

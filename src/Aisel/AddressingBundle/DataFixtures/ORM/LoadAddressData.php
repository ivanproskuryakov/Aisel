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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\AddressingBundle\Entity\Address;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadAddressData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // references
        $frontendUser = $this->getReference('frontenduser');
        $city = $this->getReference('city');
        $region = $this->getReference('region');

        $address = new Address();
        $address->setPhone('+34 917 74 10 00');
        $address->setStreet('Calle de Santa Isabel, 52');
        $address->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $address->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $address->setFrontenduser($frontendUser);
        $address->setRegion($region);
        $address->setCity($city);
        $address->setZip('28012');
        $address->setComment('The Museo Nacional Centro de Arte Reina Sofía is Spain\'s');
        $manager->persist($address);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 550;
    }
}

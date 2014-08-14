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
use Aisel\AddressingBundle\Entity\City;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCityData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $city = new City();
        $city->setName('Madrid');
        $city->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $city->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($city);
        $manager->flush();

        $this->addReference('city', $city);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 500;
    }
}

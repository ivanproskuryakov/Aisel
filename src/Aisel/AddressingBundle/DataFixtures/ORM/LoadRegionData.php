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
use Aisel\AddressingBundle\Entity\Region;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadRegionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $region = new Region();
        $region->setName('Comunidad de Madrid');
        $region->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $region->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($region);
        $manager->flush();

        $this->addReference('region', $region);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 510;
    }
}

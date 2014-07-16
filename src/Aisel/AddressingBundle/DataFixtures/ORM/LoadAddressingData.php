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
class LoadAddressingData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $addressing = new Address();
        $addressing->setAddress('Calle de Santa Isabel, 52, 28012 Madrid, Spain');
        $addressing->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $addressing->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($addressing);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 500;
    }
}

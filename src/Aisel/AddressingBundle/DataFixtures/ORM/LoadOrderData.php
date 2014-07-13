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
use Doctrine\Common\DataFixtures\AddressingedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\AddressingBundle\Entity\Addressing;

/**
 * Addressing fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadAddressingData extends AbstractFixture implements AddressingedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $addressing = new Addressing();
        $addressing->setStatus('new');
        $addressing->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $addressing->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($addressing);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getAddressing()
    {
        return 200;
    }
}

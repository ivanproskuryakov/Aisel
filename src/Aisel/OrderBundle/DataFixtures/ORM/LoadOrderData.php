<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\OrderBundle\Entity\Order;

/**
 * Order fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $frontendUser = $this->getReference('frontenduser_149'); // FrontendUser
        $order = new Order();
        $order->setStatus('new');
        $order->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $order->setFrontenduser($frontendUser);
        $manager->persist($order);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 600;
    }
}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\CartBundle\Entity\Cart;

/**
 * Cart fixtures
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCartData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cart = new Cart();
        $cart->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $cart->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($cart);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 200;
    }
}

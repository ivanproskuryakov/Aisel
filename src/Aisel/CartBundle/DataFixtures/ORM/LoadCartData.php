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
use Doctrine\Common\DataFixtures\CartedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\CartBundle\Entity\Cart;

/**
 * Cart fixtures
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCartData extends AbstractFixture implements CartedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}

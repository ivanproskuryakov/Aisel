<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\NavigationBundle\Entity\Menu;

class LoadMenuData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $random = rand(11111,99999);
        $time = time();

        // Blog
        $menu = new Menu();
        $menu->setTitle('Blog');
        $menu->setStatus(true);
        $menu->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $menu->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($menu);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 900;
    }
}
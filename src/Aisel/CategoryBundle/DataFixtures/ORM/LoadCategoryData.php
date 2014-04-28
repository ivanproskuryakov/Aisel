<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\CategoryBundle\Entity\Category;

/**
 * Category fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $random = rand(11111,99999);
        $time = time();

        // Root Categories
        for ($i = 1; $i <= 3; $i++ ) {
            $rootCategory = new Category();
            $rootCategory->setTitle('Root '. $i);
            $rootCategory->setDescription('dummy root description ...');
            $rootCategory->setStatus(true);
            $rootCategory->setMetaUrl('root-category-'.$i);
            $rootCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $rootCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $manager->persist($rootCategory);
            $manager->flush();
        }

        // Fist Level Categories
        for ($a = 1; $a <= 5; $a++ ) {
            $childCategory = new Category();
            $childCategory->setTitle('First '. $a);
            $childCategory->setDescription('dummy description for category ...');
            $childCategory->setParent($rootCategory);
            $childCategory->setStatus(true);
            $childCategory->setMetaUrl('category-first-level-'.  $a);
            $childCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $childCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $manager->persist($childCategory);
            $manager->flush();
        }

        // Nested Categories
        for ($b = 1; $b <= 3; $b++ ) {

            if (!isset($nestedCategory)) {
                $parent = $childCategory;
            } else {
                $parent = $nestedCategory;
            }
            $nestedCategory = new Category();
            $nestedCategory->setTitle('Nested '. $b);
            $nestedCategory->setDescription('dummy description for nested category ...');
            $nestedCategory->setParent($parent);
            $nestedCategory->setStatus(true);
            $nestedCategory->setMetaUrl('category-nested-level-'.  $b);
            $nestedCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $nestedCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $manager->persist($nestedCategory);
            $manager->flush();
        }

        $this->addReference('root-category', $rootCategory);
        $this->addReference('child-category', $childCategory);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
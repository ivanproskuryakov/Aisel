<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\PageBundle\Entity\Category;

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

        // Root Categories
        $rootCategory = new Category();
        $rootCategory->setTitle('Root One');
        $rootCategory->setDescription('Mockups can be a very important part of a presentation, especially for those who design applications for mobile devices or computers. Our MacBook Air and Pro mockups are designed ');
        $rootCategory->setStatus(true);
        $rootCategory->setMetaUrl('root-category-one');
        $rootCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $rootCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($rootCategory);
        $manager->flush();

        $rootCategory = new Category();
        $rootCategory->setTitle('Root Two');
        $rootCategory->setDescription('to showcase the work of programmers and designers so that they can have something to show their clients before the app is fully completed. These mockups are available in 1366x768 and ');
        $rootCategory->setStatus(true);
        $rootCategory->setMetaUrl('root-category-two');
        $rootCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $rootCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($rootCategory);
        $manager->flush();

        $rootCategory = new Category();
        $rootCategory->setTitle('Root Three');
        $rootCategory->setDescription('1280x800 resolutions for optimal viewing quality. Using mockups saves designers time by giving them something to display in presentations with clients so that they can get a better idea as to what the finished program will look like.');
        $rootCategory->setStatus(true);
        $rootCategory->setMetaUrl('root-category-three');
        $rootCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $rootCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($rootCategory);
        $manager->flush();

        // Fist Level Categories
        $childCategory = new Category();
        $childCategory->setTitle('First 1');
        $childCategory->setDescription('Those who use our website will find that it is easy to generate high quality MacBook, iPad, iMac, and iPhone mockups by simply uploading an image from their computer or a web screen ');
        $childCategory->setParent($rootCategory);
        $childCategory->setStatus(true);
        $childCategory->setMetaUrl('category-first-level-1');
        $childCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $childCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($childCategory);
        $manager->flush();

        $childCategory = new Category();
        $childCategory->setTitle('First 2');
        $childCategory->setDescription('shot. The mockup is generated within a matter of minutes and is guaranteed to look one hundred percent professional. We take great pride in creating mockups that look sharp and are perfect for ');
        $childCategory->setParent($rootCategory);
        $childCategory->setStatus(true);
        $childCategory->setMetaUrl('category-first-level-2');
        $childCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $childCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($childCategory);
        $manager->flush();

        $childCategory = new Category();
        $childCategory->setTitle('First 3');
        $childCategory->setDescription('professionals who need an impressive visual aid to show to their clients when designing a new app.');
        $childCategory->setParent($rootCategory);
        $childCategory->setStatus(true);
        $childCategory->setMetaUrl('category-first-level-3');
        $childCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $childCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($childCategory);
        $manager->flush();

        // Nested Categories
        $nestedCategory = new Category();
        $nestedCategory->setTitle('Nested 1');
        $nestedCategory->setDescription('By using our mockups in work or school presentations, you will be able to give your audience a good sense as to what the application looks like and even how it functions. Anyone who is ');
        $nestedCategory->setParent($childCategory);
        $nestedCategory->setStatus(true);
        $nestedCategory->setMetaUrl('category-nested-level-1');
        $nestedCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $nestedCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($nestedCategory);
        $manager->flush();

        $nestedCategory = new Category();
        $nestedCategory->setTitle('Nested 2');
        $nestedCategory->setDescription('designing an app specifically for a Mac device will certainly want to look into what we have to offer when it comes to these kinds of products. It can be difficult to describe how an application ');
        $nestedCategory->setParent($childCategory);
        $nestedCategory->setStatus(true);
        $nestedCategory->setMetaUrl('category-nested-level-2');
        $nestedCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $nestedCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($nestedCategory);
        $manager->flush();

        $nestedCategory = new Category();
        $nestedCategory->setTitle('Nested 3');
        $nestedCategory->setDescription('works or looks like, which is why it is such a good idea to employ visual aids like these. MacBook mockups are perfect for presentations with clients because they are able to convey more than words ever could.');
        $nestedCategory->setParent($childCategory);
        $nestedCategory->setStatus(true);
        $nestedCategory->setMetaUrl('category-nested-level-3');
        $nestedCategory->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $nestedCategory->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($nestedCategory);
        $manager->flush();

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

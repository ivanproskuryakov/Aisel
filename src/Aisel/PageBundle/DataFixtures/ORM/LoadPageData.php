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
use Aisel\PageBundle\Entity\Page;
use Aisel\CategoryBundle\Entity\Category;

class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $random = rand(11111,99999);
        $time = time();

        // referenced Categories
        $rootCategory = $this->getReference('root-category');
        $childCategory = $this->getReference('child-category');

        // Pages
        for ($i = 1; $i <= 10; $i++ ) {
            $page = new Page();
            $page->setTitle('Sample Page '. $i);
            $page->setContent('empty content');
            $page->setContent('dummy content for Page '.$i);
            $page->setStatus(true);
            $page->addCategory($rootCategory);
            $page->addCategory($childCategory);
            $page->setCommentStatus(false);
            $page->setMetaUrl('page-'.$i);
            $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

            $manager->persist($page);
            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
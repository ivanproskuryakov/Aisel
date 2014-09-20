<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\DataFixtures\XMLFixtureData;
use Aisel\PageBundle\Entity\Page;

/**
 * Page fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadPageData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_page.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            // todo: remove hardcode from fixtures
            $category = $this->getReference('page_category_1270');
            foreach ($XML->database->table as $table) {
                $page = new Page();
                $page->setLocale($table->column[1]);
                $page->setTitle($table->column[2]);
                $page->setContent($table->column[3]);
                $page->setStatus($table->column[4]);
                $page->setHidden($table->column[5]);
                $page->setCommentStatus($table->column[6]);
                $page->addCategory($category);
                $page->setMetaUrl($table->column[7]);
                $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $manager->persist($page);
                $manager->flush();
                $this->addReference('page_' . $table->column[0], $page);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 210;
    }
}

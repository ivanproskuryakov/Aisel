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
use Aisel\PageBundle\Entity\Category;

/**
 * Page Category fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadPageCategoryData extends XMLFixtureData implements OrderedFixtureInterface
{

    protected $fixturesName = 'aisel_page_category.xml';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (file_exists($this->fixturesFile)) {
            $contents = file_get_contents($this->fixturesFile);
            $XML = simplexml_load_string($contents);

            foreach ($XML->database->table as $table) {
                $rootCategory = null;

                if ($table->column[2] != 'NULL') {
                    $rootCategory = $this->getReference('page_category_' . $table->column[2]);
                }
                $category = new Category();
                $category->setLocale($table->column[1]);
                $category->setTitle($table->column[3]);
                $category->setDescription($table->column[8]);
                $category->setStatus($table->column[9]);
                $category->setMetaUrl($table->column[10]);
                $category->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
                $category->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

                if ($rootCategory) {
                    $category->setParent($rootCategory);
                }
                $manager->persist($category);
                $manager->flush();
                $this->addReference('page_category_' . $table->column[0], $category);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 200;
    }
}

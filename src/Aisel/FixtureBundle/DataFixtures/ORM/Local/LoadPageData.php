<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\ORM\Local;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\PageBundle\Entity\Page;

/**
 * Page fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadPageData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_page.xml',
//        'ru/aisel_page.xml',
//        'es/aisel_page.xml',
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtureFiles as $file) {
            if (file_exists($file)) {
                $contents = file_get_contents($file);
                $XML = simplexml_load_string($contents);

                foreach ($XML->database->table as $table) {
                    $page = new Page();
                    $page->setLocale($table->column[1]);
                    $page->setName($table->column[2]);
                    $page->setContent($table->column[3]);
                    $page->setStatus($table->column[4]);
                    $page->setCommentStatus($table->column[6]);
                    $page->setMetaUrl($table->column[7]);
                    $nodes = explode(",", $table->column[8]);

                    foreach ($nodes as $c) {
                        $node = $this->getReference('page_node_' . $c);
                        $page->addNode($node);
                    }

                    $manager->persist($page);
                    $manager->flush();

                    $this->addReference('page_' . $table->column[0], $page);
                }
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

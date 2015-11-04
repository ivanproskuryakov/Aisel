<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\DataFixtures\MongoDB\Local;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\PageBundle\Document\Node;

/**
 * Page Node fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadPageNodeData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_page_node.xml',
        'ru/aisel_page_node.xml',
        'es/aisel_page_node.xml',
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
                    $parent = null;

                    if ($table->column[2] != 'NULL') {
                        $parent = $this->getReference('page_node_' . $table->column[2]);
                    }
                    $node = new Node();
                    $node->setLocale($table->column[1]);
                    $node->setTitle($table->column[3]);
                    $node->setDescription($table->column[8]);
                    $node->setStatus((int)$table->column[9]);
                    $node->setMetaUrl($table->column[10]);

                    if ($parent) {
                        $node->setParent($parent);
                    }
                    $manager->persist($node);
                    $manager->flush();
                    $this->addReference('page_node_' . $table->column[0], $node);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 230;
    }
}

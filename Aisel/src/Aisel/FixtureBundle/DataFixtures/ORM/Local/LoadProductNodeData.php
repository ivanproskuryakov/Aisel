<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FixtureBundle\DataFixtures\ORM\Local;

use Aisel\FixtureBundle\Model\XMLFixture;
use Aisel\ProductBundle\Entity\Node;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Product Nodes
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadProductNodeData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_product_node.xml',
        'ru/aisel_product_node.xml',
        'es/aisel_product_node.xml',
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

                    $node = new Node();
                    $node->setLocale($table->column[2]);
                    $node->setName($table->column[4]);
                    $node->setContent($table->column[9]);
                    $node->setStatus((int)$table->column[10]);
                    $node->setMetaUrl($table->column[11]);

                    if ($table->column[3] != 'NULL') {
                        $parent = $this->getReference('product_node_' . $table->column[3]);
                        $node->setParent($parent);
                    }
                    $manager->persist($node);
                    $manager->flush();
                    $this->addReference('product_node_' . $table->column[0], $node);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 300;
    }
}

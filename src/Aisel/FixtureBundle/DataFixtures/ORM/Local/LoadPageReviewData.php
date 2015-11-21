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
use Aisel\ReviewBundle\Entity\Review;

/**
 * Page fixtures
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class LoadPageReviewData extends XMLFixture implements OrderedFixtureInterface
{

    protected $fixturesName = array(
        'en/aisel_page_review.xml',
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
                    $review = new Review();
                    $review->setLocale($table->column[1]);
                    $review->setTitle($table->column[2]);
                    $review->setContent($table->column[3]);
                    $review->setStatus($table->column[4]);

                    $nodes = explode(",", $table->column[5]);

                    foreach ($nodes as $c) {
                        $node = $this->getReference('page_review_node_' . $c);
                        $review->addNode($node);
                    }

                    $manager->persist($review);
                    $manager->flush();

                    $this->addReference('page_review_' . $table->column[0], $review);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 220;
    }
}

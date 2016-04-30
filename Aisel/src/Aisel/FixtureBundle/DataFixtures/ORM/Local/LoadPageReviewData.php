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
use Aisel\PageBundle\Entity\Review;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
                    $user = $this->getReference('user_' . $table->column[5]);
                    $page = $this->getReference('page_' . $table->column[6]);

                    $review = new Review();
                    $review->setLocale($table->column[1]);
                    $review->setName($table->column[2]);
                    $review->setContent($table->column[3]);
                    $review->setStatus($table->column[4]);
                    $review->setUser($user);
                    $review->setSubject($page);

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
        return 230;
    }
}

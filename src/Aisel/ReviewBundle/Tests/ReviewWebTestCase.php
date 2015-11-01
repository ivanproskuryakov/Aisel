<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\ReviewBundle\Document\Review;
use Aisel\ReviewBundle\Document\Node;
use Faker;

/**
 * ReviewWebTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ReviewWebTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * newNode
     *
     * @return Node $node
     */
    public function newReviewNode()
    {
        $node = new Node();
        $node->setStatus(true);
        $node->setDescription($this->faker->sentence(10));
        $node->setMetaUrl('url_' . time() + rand(11111, 99999));
        $node->setLocale('en');

        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * newReview
     *
     * @param Node $node
     *
     * @return Review $review
     */
    public function newReview(Node $node = null)
    {
        $review = new Review();
        $review->setLocale('en');
        $review->setTitle($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setStatus(true);
        $review->setCommentStatus(true);
        $review->setMetaUrl('url_' . time() . rand(11111, 99999));
        if ($node) {
            $review->addNode($node);
        }

        $this->dm->persist($review);
        $this->dm->flush();

        return $review;
    }

}

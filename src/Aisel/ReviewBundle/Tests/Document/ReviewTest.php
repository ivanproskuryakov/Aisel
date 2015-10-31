<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Document;

use Aisel\ReviewBundle\Tests\ReviewWebTestCase;
use Aisel\ReviewBundle\Document\Review;
use Aisel\ReviewBundle\Document\Node;
use Faker;

/**
 * ReviewTests
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ReviewTests extends ReviewWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDuplicateNodes()
    {
        $node = $this->newReviewNode();

        $this->assertNotNull($node->getId());

        $review = $this->newReview($node);
        $review->addNode($node);
        $this->dm->persist($review);
        $this->dm->flush();

        $this->assertNotNull($review->getId());
        $this->assertEquals(count($review->getNodes()), 1);

        $this->dm->remove($node);
        $this->dm->flush();
        $this->dm->remove($review);
        $this->dm->flush();
    }

}

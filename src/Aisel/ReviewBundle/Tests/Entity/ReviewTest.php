<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Entity;

use Aisel\ReviewBundle\Tests\ReviewWebTestCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
        $this->setExpectedException(UniqueConstraintViolationException::class);

        $node = $this->newReviewNode();

        $this->assertNotNull($node->getId());

        $review = $this->newReview($node);
        $review->addNode($node);
        $this->em->persist($review);
        $this->em->flush();

        $this->assertNotNull($review->getId());
        $this->assertEquals(count($review->getNodes()), 1);

        $this->removeEntity($review);
        $this->removeEntity($node);
    }

    public function testChildParentNodes()
    {
        $parent = $this->newReviewNode();
        $child = $this->newReviewNode();
        $child->setParent($parent);

        $this->em->persist($child);
        $this->em->flush();

        $this->removeEntity($parent);
    }

}

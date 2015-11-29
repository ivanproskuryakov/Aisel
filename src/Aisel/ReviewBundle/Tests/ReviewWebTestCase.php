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
use Aisel\ReviewBundle\Entity\Review;
use Aisel\ReviewBundle\Entity\Node;
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
        $node->setName($this->faker->sentence(1));
        $node->setContent($this->faker->sentence(10));
        $node->setLocale('en');

        $this->em->persist($node);
        $this->em->flush();

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
        $user = $this
            ->em
            ->getRepository('Aisel\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'frontenduser']);

        $review = new Review();
        $review->setLocale('en');
        $review->setName($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setStatus(true);
        $review->setFrontenduser($user);
        if ($node) {
            $review->addNode($node);
        }

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

}

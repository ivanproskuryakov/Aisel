<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests;

use Aisel\ProductBundle\Entity\Review;
use Aisel\ProductBundle\Entity\Node;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * ProductWebTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductWebTestCase extends AbstractWebTestCase
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
    public function newNode()
    {
        $node = new Node();
        $node->setName($this->faker->sentence());
        $node->setStatus(true);
        $node->setContent($this->faker->sentence());
        $node->setLocale('en');
        $node->setMetaUrl($this->faker->sentence());

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * newReview
     *
     * @return Review $review
     */
    public function newReview()
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

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }


}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Entity;

use Aisel\ProductBundle\Entity\Review;
use Aisel\ProductBundle\Tests\ProductWebTestCase;
use Faker;

/**
 * ProductTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductReviewTest extends ProductWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testProductReview()
    {
        $this->logInFrontend();
        $product = $this->newProduct();

        $review = new Review();
        $review->setLocale('en');
        $review->setName($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setSubject($product);
        $this->em->persist($review);
        $this->em->flush();

        $review = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNotNull($review);
    }

}

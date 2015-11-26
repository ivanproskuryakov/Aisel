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

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;
use Aisel\ProductBundle\Entity\Product;
use Aisel\MediaBundle\Entity\Media;
use Aisel\ReviewBundle\Entity\Review;
use Aisel\ReviewBundle\Entity\Node as ReviewNode;

/**
 * ProductTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductReviewTest extends AbstractWebTestCase
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
        $this->markTestSkipped('skipping ...');
        $node = new ReviewNode();
        $node->setStatus(true);
        $node->setTitle($this->faker->sentence(1));
        $node->setDescription($this->faker->sentence(10));
        $node->setLocale('en');
        $this->em->persist($node);
        $this->em->flush();

        $review = new Review();
        $review->setTitle($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->addNode($node);
        $this->em->persist($review);
        $this->em->flush();

        $product = new Product();
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setDescriptionShort($this->faker->sentence(10));
        $product->setDescription($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addReview($review);

        $this->em->persist($product);
        $this->em->flush();

        $this->assertNotNull($product->getId());
        $this->removeEntity($product);

        $review = $this
            ->em
            ->getRepository('Aisel\ReviewBundle\Entity\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNull($review);
    }

}

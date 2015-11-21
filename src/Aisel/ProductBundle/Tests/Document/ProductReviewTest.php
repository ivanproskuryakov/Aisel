<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Document;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;
use Aisel\ProductBundle\Document\Product;
use Aisel\MediaBundle\Document\Media;
use Aisel\ReviewBundle\Document\Review;
use Aisel\ReviewBundle\Document\Node as ReviewNode;

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
        $this->dm->persist($node);
        $this->dm->flush();

        $review = new Review();
        $review->setTitle($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->addNode($node);
        $this->dm->persist($review);
        $this->dm->flush();

        $product = new Product();
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setDescriptionShort($this->faker->sentence(10));
        $product->setDescription($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addReview($review);

        $this->dm->persist($product);
        $this->dm->flush();

        $this->assertNotNull($product->getId());
        $this->removeDocument($product);

        $review = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNull($review);
    }

}

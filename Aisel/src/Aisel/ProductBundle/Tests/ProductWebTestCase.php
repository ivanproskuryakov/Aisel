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

use Aisel\ProductBundle\Entity\Node;
use Aisel\ProductBundle\Entity\Product;
use Aisel\ProductBundle\Entity\Review;
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
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        $review = new Review();
        $review->setLocale('en');
        $review->setName($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setStatus(true);
        $review->setUser($user);

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    /**
     * newProduct
     *
     * @return Product $product
     */
    public function newProduct()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        $product = new Product();

        $product->setUser($user);
        $product->setLocale('en');
        $product->setName($this->faker->sentence());
        $product->setSku($this->faker->randomDigit);
        $product->setPrice($this->faker->randomDigit);
        $product->setQty($this->faker->randomDigit);
        $product->setContentShort($this->faker->sentence());
        $product->setContent($this->faker->text());
        $product->setStatus(true);
        $product->setHidden(false);
        $product->setCommentStatus(false);
        $product->setMetaUrl($this->faker->numberBetween(100000000, 9999999999));

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }


}

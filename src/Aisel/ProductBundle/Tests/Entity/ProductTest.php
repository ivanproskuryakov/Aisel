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
use Aisel\ProductBundle\Entity\Node;
use Aisel\MediaBundle\Entity\Media;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * ProductTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductTest extends AbstractWebTestCase
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

        $node = new Node();
        $node->setStatus(true);
        $node->setName($this->faker->sentence(1));
        $node->setContent($this->faker->sentence(10));
        $node->setMetaUrl('url_' . time());
        $node->setLocale('en');

        $this->em->persist($node);
        $this->em->flush();

        $this->assertNotNull($node->getId());

        $product = new Product();
        $product->setLocale('en');
        $product->setSku($this->faker->numberBetween());
        $product->setName($this->faker->sentence(1));
        $product->setContentShort($this->faker->sentence(10));
        $product->setContent($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addNode($node);
        $product->addNode($node);

        $this->em->persist($product);
        $this->em->flush();
    }

    public function testDuplicateImages()
    {
        $this->markTestSkipped('...');
        $image = new Media();
        $image->setFilename($this->faker->numberBetween(0, 10000));
        $image->setMainImage(false);

        $this->em->persist($image);
        $this->em->flush();

        $this->assertNotNull($image->getId());

        $product = new Product();
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setContentShort($this->faker->sentence(10));
        $product->setContent($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addMedia($image);
        $product->addMedia($image);

        $this->em->persist($product);
        $this->em->flush();

        $this->assertNotNull($product->getId());
        $this->assertEquals(count($product->getMedias()), 1);

        $this->em->remove($image);
        $this->em->flush();
        $this->em->remove($product);
        $this->em->flush();
    }

}

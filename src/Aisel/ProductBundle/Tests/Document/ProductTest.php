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
use Aisel\ProductBundle\Document\Node;
use Aisel\MediaBundle\Document\Media;

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
        $node = new Node();
        $node->setStatus(true);
        $node->setDescription($this->faker->sentence(10));
        $node->setMetaUrl('url_' . time());
        $node->setLocale('en');

        $this->dm->persist($node);
        $this->dm->flush();

        $this->assertNotNull($node->getId());

        $product = new Product();
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setDescriptionShort($this->faker->sentence(10));
        $product->setDescription($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addNode($node);
        $product->addNode($node);

        $this->dm->persist($product);
        $this->dm->flush();

        $this->assertNotNull($product->getId());
        $this->assertEquals(count($product->getNodes()), 1);

        $this->dm->remove($node);
        $this->dm->flush();
        $this->dm->remove($product);
        $this->dm->flush();
    }

    public function testDuplicateImages()
    {
        $image = new Media();
        $image->setFilename($this->faker->numberBetween(0, 10000));
        $image->setMainImage(false);

        $this->dm->persist($image);
        $this->dm->flush();

        $this->assertNotNull($image->getId());

        $product = new Product();
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setDescriptionShort($this->faker->sentence(10));
        $product->setDescription($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addMedia($image);
        $product->addMedia($image);

        $this->dm->persist($product);
        $this->dm->flush();

        $this->assertNotNull($product->getId());
        $this->assertEquals(count($product->getMedias()), 1);

        $this->dm->remove($image);
        $this->dm->flush();
        $this->dm->remove($product);
        $this->dm->flush();
    }

}

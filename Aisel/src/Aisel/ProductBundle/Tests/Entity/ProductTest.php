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

use Aisel\MediaBundle\Entity\Media;
use Aisel\ProductBundle\Entity\Node;
use Aisel\ProductBundle\Entity\Product;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

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
        $this->setExpectedException('Doctrine\DBAL\Exception\UniqueConstraintViolationException');
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

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
        $product->setUser($user);
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
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        $this->setExpectedException('Doctrine\DBAL\Exception\UniqueConstraintViolationException');
        $image = new Media();
        $image->setType(Media::MEDIA_IMAGE);
        $image->setFilename($this->faker->numberBetween(0, 10000));
        $image->setMainImage(false);

        $this->em->persist($image);
        $this->em->flush();

        $this->assertNotNull($image->getId());

        $product = new Product();
        $product->setUser($user);
        $product->setLocale('en');
        $product->setName($this->faker->sentence(1));
        $product->setContentShort($this->faker->sentence(10));
        $product->setContent($this->faker->sentence(10));
        $product->setStatus(true);
        $product->setSku($this->faker->numberBetween());
        $product->setCommentStatus(true);
        $product->setMetaUrl('url_' . time());
        $product->addMedia($image);
        $product->addMedia($image);

        $this->em->persist($product);
        $this->em->flush();
    }

}

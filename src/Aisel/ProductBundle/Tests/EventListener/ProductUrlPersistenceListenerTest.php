<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\EventListener;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\ProductBundle\Entity\Product;

/**
 * ProductUrlPersistenceListenerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductUrlPersistenceListenerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDuplicatedUrlThrowsError()
    {
        $urlText = 'product-test-meta-url';
        $this->setExpectedException(
            'LogicException', 'Given URL already exists'
        );

        // Create Product 1
        $product1 = new Product();
        $product1->setLocale('en');
        $product1->setDescription('...');
        $product1->setDescriptionShort('...');
        $product1->setInStock(false);
        $product1->setName('...');
        $product1->setSku('test-1');
        $product1->setStatus(true);
        $product1->setMetaUrl($urlText);
        $product1->setMetaTitle('...');
        $product1->setCommentStatus(true);

        $this->em->persist($product1);
        $this->em->flush();

        // Create Product 2
        $product2 = new Product();
        $product2->setLocale('en');
        $product2->setDescription('...');
        $product2->setDescriptionShort('...');
        $product2->setInStock(false);
        $product2->setName('...');
        $product2->setSku('test-2');
        $product2->setStatus(true);
        $product2->setMetaUrl($urlText);
        $product2->setMetaTitle('...');
        $product2->setCommentStatus(true);

        $this->em->persist($product2);
        $this->em->flush();

        // Delete Product 1
        $product1 = $this->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['metaUrl' => $urlText]);

        $this->em->remove($product1);
        $this->em->flush();
    }

}

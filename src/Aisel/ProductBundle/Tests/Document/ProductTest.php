<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Document;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;
use Aisel\ProductBundle\Document\Product;
use Aisel\ProductBundle\Document\Node;

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
        $faker = Faker\Factory::create();

        $node = new Node();
        $node->setStatus(true);
        $node->setDescription($faker->sentence(10));
        $node->setMetaUrl('url_' . time());
        $node->setLocale('en');

        $this->dm->persist($node);
        $this->dm->flush();

        $this->assertNotNull($node->getId());

        $page = new Product();
        $page->setLocale('en');
        $page->setName($faker->sentence(1));
        $page->setDescriptionShort($faker->sentence(10));
        $page->setDescription($faker->sentence(10));
        $page->setStatus(true);
        $page->setCommentStatus(true);
        $page->setMetaUrl('url_' . time());
        $page->addNode($node);
        $page->addNode($node);

        $this->dm->persist($page);
        $this->dm->flush();

        $this->assertNotNull($page->getId());
        $this->assertEquals(count($page->getNodes()), 1);

        $this->dm->remove($node);
        $this->dm->flush();
        $this->dm->remove($page);
        $this->dm->flush();
    }

}

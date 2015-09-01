<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;
use Faker;

/**
 * DuplicatedNodeTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class DuplicatedNodeTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostAction()
    {
        $faker = Faker\Factory::create();
        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'name' => $faker->sentence(1),
            'sku' => $faker->numberBetween(100000, 900000),
            'price' => $faker->numberBetween(1, 100),
            'content' => $faker->paragraph(10),
            'description_short' => $faker->paragraph(10),
            'description' => $faker->paragraph(10),
            'status' => true,
            'meta_url' => 'metaUrl_' . $faker->numberBetween(100000, 900000),
            'meta_title' => 'metaTitle_' . $faker->numberBetween(100000, 900000),
            'comment_status' => false,
            'nodes' => [
                ['id' => $productNode->getId()],
                ['id' => $productNode->getId()],
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/product/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->find($id);

        $this->assertEquals($product->getNodes()[0]->getId(), $productNode->getId());
        $this->assertEquals(count($product->getNodes()), 1);
    }

}

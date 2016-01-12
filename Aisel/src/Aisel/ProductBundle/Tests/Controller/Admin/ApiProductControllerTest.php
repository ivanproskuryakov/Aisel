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

use Aisel\ProductBundle\Tests\ProductWebTestCase;

/**
 * ApiProductControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiProductControllerTest extends ProductWebTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->logInBackend();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetProductsAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/product/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testPostProductAction()
    {
        $data = [
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
        $statusCode = $response->getStatusCode();

        $this->assertEquals(405, $statusCode); // No route found
    }

    public function testPutProductAction()
    {
        $product = $this->newProduct();

        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['locale' => 'ru']);

        $id = $product->getId();
        $data = [
            'locale' => 'ru',
            'nodes' => [
                [
                    'id' => $node->getId()
                ]
            ]
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/product/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($product);
        $this->assertEquals($data['locale'], $product->getLocale());
        $this->assertEquals($data['nodes'][0]['id'], $product->getNodes()->first()->getId());
    }

    public function testGetProductAction()
    {
        $product = $this->newProduct();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $product->getId());
    }

    public function testDeleteProductAction()
    {
        $product = $this->newProduct();

        $medias = $product->getMedias()->toArray();

        $id = $product->getId();
        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/product/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $foundProduct = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($foundProduct);

        foreach ($medias as $media) {
            $foundMedia = $this
                ->em
                ->getRepository('Aisel\MediaBundle\Entity\Media')
                ->findOneBy(['id' => $media->getId()]);
            $this->assertNull($foundMedia);
        }

    }
}

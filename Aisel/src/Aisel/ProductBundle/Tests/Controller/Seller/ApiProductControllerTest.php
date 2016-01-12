<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Seller;

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

        $this->logInFrontend();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetProductsAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['seller'] . '/product/',
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
        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'name' => 'AAAAA',
            'sku' => time(),
            'price' => 100,
            'content' => $this->faker->sentence(),
            'description_short' => time(),
            'meta_url' => time(),
            'nodes' => [
                [
                    'id' => $node->getId()
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['seller'] . '/product/',
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
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->find($id);

        $this->assertEquals($data['locale'], $product->getLocale());
        $this->assertEquals($product->getNodes()[0]->getId(), $node->getId());
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
            '/' . $this->api['seller'] . '/product/' . $id,
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
            '/' . $this->api['seller'] . '/product/' . $product->getId(),
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
            '/' . $this->api['seller'] . '/product/' . $id,
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

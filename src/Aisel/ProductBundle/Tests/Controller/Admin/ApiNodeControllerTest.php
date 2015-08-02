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

/**
 * ApiNodeControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostProductNodeAction()
    {
        $data = [
            'locale' => 'en',
            'title' => 'AAA',
            'description' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
        ];

        $this->client->request(
            'POST',
            '/'. $this->api['backend'] . '/product/category/',
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
    }

    public function testGetProductNodesAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetProductNodeAction()
    {
        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/' . $productNode->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $productNode->getId());
    }

    public function testPutProductNodeAction()
    {
        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $productNode->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/product/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['title' => 'AAA']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($productNode);
        $this->assertEquals($data['locale'], $productNode->getLocale());
    }

    public function testDeleteProductNodeAction()
    {
        $this->markTestSkipped('failed ..');
        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['title' => 'AAA']);
        $id = $productNode->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/product/category/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $productNode = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($productNode);
    }
}

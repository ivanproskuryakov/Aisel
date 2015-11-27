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
 * ApiNodeControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeControllerTest extends ProductWebTestCase
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
            '/'. $this->api['backend'] . '/product/node/',
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
            '/'. $this->api['backend'] . '/product/node/?locale=en'
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
        $node = $this->newNode();

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/node/' . $node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $node->getId());
    }

    public function testPutProductNodeAction()
    {
        $node1 = $this->newNode();
        $node2 = $this->newNode();

        $data['locale'] = 'ru';
        $data['parent'] = ['id' => $node1->getId()];

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/product/node/' . $node2->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['id' => $node1->getId()]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($node);
        $this->assertEquals(1, count($node->getChildren()));
    }

    public function testDeleteProductNodeAction()
    {
        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['title' => 'AAA']);
        $id = $node->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/product/node/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($node);
    }
}

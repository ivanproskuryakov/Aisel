<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Controller\Admin;

use Aisel\PageBundle\Tests\PageWebTestCase;

/**
 * ApiNodeControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeControllerTest extends PageWebTestCase
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

    public function testPostPageNodeAction()
    {
        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'description' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
        ];

        $this->client->request(
            'POST',
            '/'. $this->api['backend'] . '/page/node/',
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

    public function testGetPageNodesAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/page/node/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));

    }

    public function testGetPageNodeAction()
    {
        $node = $this->newNode();

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/page/node/' . $node->getId(),
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

//        $this->removeEntity($node);
    }

    public function testPutPageNodeAction()
    {
        $node1  = $this->newNode();
        $node2 = $this->newNode();

        $data['locale'] = 'ru';
        $data['description'] = time();
        $data['parent'] = ['id' => $node1->getId()];

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/page/node/' . $node2->getId(),
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
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['id' => $node1]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($node);
        $this->assertEquals(1, count($node->getChildren()));
    }

    public function testDeletePageNodeAction()
    {
        $node = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['name' => 'AAA']);
        $id = $node->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/page/node/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($node);
    }

}

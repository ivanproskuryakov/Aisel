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

    public function testNodeUpdateParentAction()
    {
        $child = $this->newNode();
        $parent = $this->newNode();

        $data = [
            'parent' => [
                'id' => $parent->getId()
            ],
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/page/node/' . $child->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );


        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEmpty($content);
        $this->assertTrue(204 === $statusCode);

        $node = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['id' => $child->getId()]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());
    }

    public function testNodeAddChildAction()
    {
        $parent = $this->newNode();

        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'content' => $this->faker->sentence(),
            'status' => true,
            'meta_url' => 'metaUrl_' . $this->faker->randomNumber(),
            'meta_title' => 'metaTitle_' . $this->faker->randomNumber(),
            'parent' => [
                'id' => $parent->getId()
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/page/node/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $this->assertTrue(201 === $statusCode);
        $this->assertEmpty($content);


        $this->em->clear();

        $node = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['id' => $id]);


        $parent = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['id' => $parent->getId()]);


        $this->assertEquals($node->getParent()->getId(), $parent->getId());
        $this->assertEquals($node->getId(), $parent->getChildren()[0]->getId());
    }


    public function testPostPageNodeAction()
    {
        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'content' => $this->faker->sentence(),
            'status' => true,
            'meta_url' => 'metaUrl_' . $this->faker->randomNumber(),
            'meta_title' => 'metaTitle_' . $this->faker->randomNumber(),
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/page/node/',
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
            '/' . $this->api['backend'] . '/page/node/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetPageNodesAsTreeAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/page/node/tree/?locale=en'
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
            '/' . $this->api['backend'] . '/page/node/' . $node->getId(),
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

    public function testPutPageNodeAction()
    {
        $node1 = $this->newNode();
        $node2 = $this->newNode();

        $data['locale'] = 'ru';
        $data['content'] = $this->faker->sentence();
        $data['parent'] = ['id' => $node1->getId()];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/page/node/' . $node2->getId(),
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
            '/' . $this->api['backend'] . '/page/node/' . $id,
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

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Tests\Controller\Admin;

use Aisel\NavigationBundle\Entity\Menu;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiNodeControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeControllerTest extends AbstractWebTestCase
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

    public function createNode($name)
    {
        $node = new Menu();
        $node->setLocale('en');
        $node->setMetaUrl('/');
        $node->setName($name);
        $node->setStatus(true);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    public function testNodeUpdateParentAction()
    {
        $child = $this->createNode('Child');
        $parent = $this->createNode('Parent');

        $data = [
            'parent' => [
                'id' => $parent->getId()
            ],
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/navigation/' . $child->getId(),
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
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $child->getId()]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());
    }

    public function testNodeAddChildAction()
    {
        $parent = $this->createNode('AAA');

        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'content' => $this->faker->sentence(),
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
            'parent' => [
                'id' => $parent->getId()
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/navigation/',
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
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $id]);


        $parent = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $parent->getId()]);


        $this->assertEquals($node->getParent()->getId(), $parent->getId());
        $this->assertEquals($node->getId(), $parent->getChildren()[0]->getId());
    }

    public function testPostNodeAction()
    {
        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'content' => $this->faker->sentence(),
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/navigation/',
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

    public function testGetNodesAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/tree/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetNodesAsTreeAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetNodeAction()
    {
        $Node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['name' => 'AAA']);

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/' . $Node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $Node->getId());
    }

    public function testPutNodeAction()
    {
        $Node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['name' => 'AAA']);
        $id = $Node->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/navigation/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $Node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['name' => 'AAA']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($Node);
        $this->assertEquals($data['locale'], $Node->getLocale());
    }

    public function testDeleteNodeAction()
    {
        $Node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['name' => 'AAA']);
        $id = $Node->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/navigation/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $Node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($Node);
    }

}

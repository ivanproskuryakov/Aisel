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
use Aisel\ProductBundle\Entity\Category;

/**
 * ApiNodeEditControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeEditControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function createNode($name)
    {
        $node = new Category();
        $node->setLocale('en');
        $node->setDescription('');
        $node->setMetaUrl('/');
        $node->setTitle($name);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    public function testProductNodeUpdateParentAction()
    {
        $node1 = $this->createNode('AAA');
        $node2 = $this->createNode('AAA');

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en&action=dragDrop'.
            '&id='. $node1->getId().
            '&parentId='. $node2->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $node2->getId());
    }

    public function testProductNodeAddChildAction()
    {
        $node = $this->createNode('AAA');

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en'.
            '&action=addChild'.
            '&name=New+children'.
            '&parentId='. $node->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $node->getId());
    }

    public function testProductNodeChangeTitleAction()
    {
        $node = $this->createNode('AAA');

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en'.
            '&action=save'.
            '&name=BBB'.
            '&id='.$node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['title'], 'BBB');
    }

    public function testProductNodeDeleteAction()
    {
        $name = 'NODE_123';
        $node = $this->createNode($name);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en'.
            '&action=remove'.
            '&id='. $node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Category')
            ->findOneBy(['title' => $name]);

        $this->assertTrue(200 === $statusCode);
        $this->assertNull($node);
    }

}

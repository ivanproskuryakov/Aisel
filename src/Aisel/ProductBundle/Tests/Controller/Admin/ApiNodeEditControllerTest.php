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
use Aisel\ProductBundle\Document\Category;

/**
 * ApiNodeEditControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
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
        $node->setMetaUrl('/'. rand(111111,999999));
        $node->setTitle($name);
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    public function testProductNodeUpdateParentAction()
    {
        $parent = $this->createNode('Parent' . rand(1111, 9999));
        $child = $this->createNode('Child' . rand(1111, 9999));

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en&action=dragDrop'.
            '&id=' . $child->getId() .
            '&parentId=' . $parent->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $parent->getId());

        $this->dm->clear();

        $node = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['id' => $result['id']]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());
    }

    public function testProductNodeAddChildAction()
    {
        $parent = $this->createNode('AAA');

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/category/node/'.
            '?locale=en'.
            '&action=addChild'.
            '&name=New+children'.
            '&parentId='. $parent->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $parent->getId());

        $this->dm->clear();

        $parent = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['id' => $parent->getId()]);

        $node = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['id' => $result['id']]);
        $this->assertEquals($node->getParent()->getId(), $parent->getId());
        $this->assertEquals($node->getId(), $parent->getChildren()[0]->getId());
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
        $name = 'NodeToDelete';
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
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['title' => $name]);

        $this->assertTrue(200 === $statusCode);
        $this->assertNull($node);
    }

}

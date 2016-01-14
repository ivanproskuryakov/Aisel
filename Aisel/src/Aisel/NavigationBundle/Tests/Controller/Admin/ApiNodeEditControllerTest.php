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

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\NavigationBundle\Entity\Menu;

/**
 * ApiNodeEditControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeEditControllerTest extends AbstractWebTestCase
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
        $node->setStatus($name);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    public function testNavigationNodeUpdateParentAction()
    {
        $child = $this->createNode('Child');
        $parent = $this->createNode('Parent');

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/node/' .
            '?locale=en' .
            '&action=dragDrop' .
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

        $this->em->clear();

        $node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $result['id']]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($result['id'], $child->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());
    }

    public function testNavigationNodeAddChildAction()
    {
        $parent = $this->createNode('AAA');

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/node/' .
            '?locale=en' .
            '&action=addChild' .
            '&name=New+children' .
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

        $this->em->clear();

        $parent = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $parent->getId()]);

        $node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $result['id']]);

        $this->assertEquals($node->getParent()->getId(), $parent->getId());
        $this->assertEquals($node->getId(), $parent->getChildren()[0]->getId());
    }

    public function testNavigationNodeChangeTitleAction()
    {
        $node = $this->createNode('ChangeTitle');

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/node/' .
            '?locale=en' .
            '&action=save' .
            '&name=BBB' .
            '&id=' . $node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);
        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['name'], 'BBB');
    }

    public function testNavigationNodeDeleteAction()
    {
        $node = $this->createNode('DeleteMe');

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/navigation/node/' .
            '?locale=en' .
            '&action=remove' .
            '&id=' . $node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['name' => 'ZZZZ']);

        $this->assertTrue(200 === $statusCode);
        $this->assertNull($node);
    }

}

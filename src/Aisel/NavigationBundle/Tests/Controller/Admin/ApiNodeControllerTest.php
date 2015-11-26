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

    public function testPostNavigationNodeAction()
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
            '/'. $this->api['backend'] . '/navigation/',
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

    public function testGetNavigationNodesAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/navigation/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));
    }

    public function testGetNavigationNodeAction()
    {
        $navigationNode = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/navigation/' . $navigationNode->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $navigationNode->getId());
    }

    public function testPutNavigationNodeAction()
    {
        $navigationNode = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['title' => 'AAA']);
        $id = $navigationNode->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/navigation/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $navigationNode = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['title' => 'AAA']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($navigationNode);
        $this->assertEquals($data['locale'], $navigationNode->getLocale());
    }

    public function testDeleteNavigationNodeAction()
    {
        $navigationNode = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['title' => 'AAA']);
        $id = $navigationNode->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/navigation/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $navigationNode = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($navigationNode);
    }
}

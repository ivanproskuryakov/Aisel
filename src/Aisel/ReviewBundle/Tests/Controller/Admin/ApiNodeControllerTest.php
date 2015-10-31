<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Controller\Admin;

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

    public function testPostReviewNodeAction()
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
            '/'. $this->api['backend'] . '/review/node/',
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

    public function testGetReviewNodesAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/review/node/?locale=en'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(is_array($result));

    }

    public function testGetReviewNodeAction()
    {
        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/review/node/' . $node->getId(),
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

    public function testPutReviewNodeAction()
    {
        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['title' => 'AAA']);

        $node2 = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['locale' => 'en']);

        $id = $node->getId();
        $data['locale'] = 'ru';
        $data['description'] = time();
        $data['children'][] = ['id' => $node2->getId()];

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/review/node/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($node);
        $this->assertEquals($data['locale'], $node->getLocale());
        $this->assertEquals(1, count($node->getChildren()));
    }

    public function testDeleteReviewNodeAction()
    {
        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['title' => 'AAA']);
        $id = $node->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/review/node/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($node);
    }

}

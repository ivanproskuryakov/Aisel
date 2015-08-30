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

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;

/**
 * ApiPageControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiPageControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostPageAction()
    {
        $pageNode = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'title' => 'AAA',
            'content' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
            'comment_status' => false,
            'categories' => [
                [
                    'id' => $pageNode->getId()
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/page/',
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
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->find($id);

        $this->assertEquals($page->getCategories()[0]->getId(), $pageNode->getId());
    }

    public function testGetPageAction()
    {
        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findOneBy(['title' => 'AAA']);

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/page/' . $page->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $page->getId());
    }

    public function testDeletePageAction()
    {
        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findOneBy(['title' => 'AAA']);
        $id = $page->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/page/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($page);
    }

    public function testPutPageAction()
    {
        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findOneBy(['locale' => 'en']);

        $id = $page->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/page/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $page = $this
            ->dm
            ->getRepository('Aisel\PageBundle\Document\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($page);
        $this->assertEquals($data['locale'], $page->getLocale());
    }

}

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
 * ApiPageControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiPageControllerTest extends PageWebTestCase
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

    public function testPostPageAction()
    {
        $pageNode = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'name' => 'AAA',
            'content' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
            'comment_status' => false,
            'nodes' => [
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
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->find($id);

        $this->assertEquals($page->getNodes()[0]->getId(), $pageNode->getId());
        $this->assertEquals($page->getBackendUser()->getUsername(), $this->backendUser->getUsername());
    }

    public function testGetPageAction()
    {
        $page = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['backendUser' => $this->backendUser->getId()]);

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
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['backendUser' => $this->backendUser->getId()]);

        $this->assertEquals($page->getBackendUser()->getUsername(), $this->backendUser->getUsername());

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
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($page);
    }

    public function testPutPageActionThrowsNotFound()
    {
        $page = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['locale' => 'ru']);

        $this->assertNotEquals($page->getBackendUser()->getUsername(), $this->backendUser->getUsername());

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
        $result = json_decode($content, true);

        $this->assertTrue(404 === $statusCode);
        $this->assertEquals($result['message'], 'Not found');
    }

    public function testPutPageAction()
    {
        $page = $this->newPage();
        $this->assertEquals($page->getBackendUser()->getUsername(), $this->backendUser->getUsername());

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

        $this->em->clear();

        $page = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($page);
        $this->assertEquals($data['locale'], $page->getLocale());
    }

}

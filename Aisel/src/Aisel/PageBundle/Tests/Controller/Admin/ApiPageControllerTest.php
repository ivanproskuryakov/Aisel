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
        $data = [
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
        $statusCode = $response->getStatusCode();

        $this->assertEquals(405, $statusCode); // No route found
    }

    public function testGetPageAction()
    {
        $page = $this->newPage();
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
        $page = $this->newPage();
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

    public function testPutPageAction()
    {
        $page = $this->newPage();

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

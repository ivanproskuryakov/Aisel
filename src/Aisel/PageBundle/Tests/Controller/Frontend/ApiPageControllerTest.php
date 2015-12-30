<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Controller\Frontend;

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
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGePageTreeAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/en/page/node/tree/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testGetPageAction()
    {
        $page = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/en/page/' . $page->getMetaUrl(),
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

}

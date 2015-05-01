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

/**
 * NodeControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetNodesAction()
    {
        $this->client->request(
            'GET',
            '/backend/api/navigation/',
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

    public function testGetNodeAction()
    {
        $node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/backend/api/navigation/' . $node->getId(),
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

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiOrderControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiOrderControllerTest extends AbstractWebTestCase
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

    public function testGetOrdersAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/order/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testGetOrderAction()
    {
        $Order = $this
            ->em
            ->getRepository('Aisel\OrderBundle\Entity\Order')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/order/' . $Order->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $Order->getId());
    }

}

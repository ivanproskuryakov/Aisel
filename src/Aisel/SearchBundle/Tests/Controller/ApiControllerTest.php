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

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSearchNotFoundAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/en/search/?query=something that does not exists'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);
        var_dump($result);
        exit();

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertEquals(0, $result['total']);
    }

    public function testSearchFoundAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/en/search/?query=lo'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        $this->assertTrue(count($result['total']) > 0);
    }

}

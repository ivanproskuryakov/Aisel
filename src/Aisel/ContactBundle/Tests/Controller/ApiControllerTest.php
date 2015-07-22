<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\Tests\Controller;

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

    public function testContactPostAction()
    {
        $data = [
            'name' => 'name',
            'email' => 'email@mail.com',
            'phone' => '+0100000000',
            'message' => '....',
        ];

        $this->client->request(
            'POST',
            '/'. $this->api['frontend'] . '/contact/message/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
    }

}

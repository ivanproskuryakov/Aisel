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
 * @author Ivan Proskoryakov <volgodark@gmail.com>
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
            '/api/contact/message/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $result = json_decode($content, true);
        $statusCode = $response->getStatusCode();

        $this->assertEquals($result['status'], false);
        $this->assertEquals($result['message'], 0);
        $this->assertTrue(200 === $statusCode);
    }

}

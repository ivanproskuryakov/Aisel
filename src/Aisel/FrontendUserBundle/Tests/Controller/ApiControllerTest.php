<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FrontendUserBundle\Tests\Controller;

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

    public function testGetUserAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/information/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertFalse($result);
    }

    public function testRegisterUserAction()
    {
        $data = [
            'username' => $this->faker->userName,
            'password' => $this->faker->password(),
            'email' => $this->faker->email
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/user/register/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertNotNull($result);
    }

    public function testLoginUserAction()
    {
        $data = [
            'username' => 'frontenduser',
            'password' => 'frontenduser',
        ];
        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/user/login/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertTrue($result['status'] === true);
        $this->assertTrue($result['message'] === 'Successfully logged in');
    }

    public function testLogoutUserAction()
    {
        $data = [
            'username' => 'frontenduser',
            'password' => 'frontenduser',
        ];
        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/user/login/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/logout/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertTrue($result['status'] === true);
        $this->assertTrue($result['message'] === 'You have been successfully logged out!');
    }

    public function testUserForgotPasswordUserNotFoundAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/password/forgot/?email=fontenduser@aisel.co',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(500 === $statusCode);
        $this->assertEquals('User not found', $result['message']);
    }

    public function testUserForgotPasswordEmailSentAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/password/forgot/?email=volgodark@gmail.com',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals(true, $result['status']);
        $this->assertEquals('New password has been sent!', $result['message']);
    }

}

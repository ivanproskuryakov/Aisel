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

    public function testGetUserAction()
    {
        $this->client->request(
            'GET',
            '/api/user/information/',
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
            'username' => rand(11111111,999999999),
            'password' => rand(11111111,999999999),
            'email' => rand(11111111,999999999).'@aisel.co'
        ];

        $this->client->request(
            'POST',
            '/api/user/register/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(204 === $statusCode);
        $this->assertNull($result);
    }

    public function testLoginUserAction()
    {
        $data = [
            'username' => 'frontenduser',
            'password' => 'frontenduser',
        ];
        $this->client->request(
            'POST',
            '/api/user/login/',
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
        $this->client->request(
            'GET',
            '/api/user/logout/',
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
            '/api/user/password/forgot/?email=fontenduser@aisel.co',
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
            '/api/user/password/forgot/?email=volgodark@gmail.com',
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

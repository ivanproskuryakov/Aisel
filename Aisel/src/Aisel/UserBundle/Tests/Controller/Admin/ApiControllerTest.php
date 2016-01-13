<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Tests\Controller\Admin;

use Aisel\UserBundle\Entity\User;
use Aisel\UserBundle\Tests\UserTestCase;
use Aisel\UserBundle\Manager\UserMailManager;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerTest extends UserTestCase
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
            '/' . $this->api['backend'] . '/user/information/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
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
        $password = $this->faker->password();
        $email = $this->faker->email;
        $user = $this->newUser($email, $password);

        $data = [
            'email' => $email,
            'password' => $password,
        ];
        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/user/login/',
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
        $this->removeEntity($user);
    }

    public function testLogoutUserAction()
    {
        $password = $this->faker->password();
        $email = $this->faker->email;
        $user = $this->newUser($email, $password);

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/user/login/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/user/logout/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Tests\Controller\Frontend;

use Aisel\UserBundle\Entity\User;
use Aisel\UserBundle\Manager\UserMailManager;
use Aisel\UserBundle\Tests\UserTestCase;

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
            '/' . $this->api['frontend'] . '/user/information/',
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

    public function testGetLoggedUserInfoAction()
    {
        $this->logInFrontend();

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
        $this->assertNotNull($result);
    }

    public function testUpdateUserInformationAction()
    {
        $password = $this->faker->password();
        $email = $this->faker->email;
        $user = $this->newUser($email, $password);
        $this->logInFrontend($email, $password);

        $data = [
            'phone' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'about' => $this->faker->text(),
            'facebook' => $this->faker->url,
            'twitter' => $this->faker->url,
        ];

        $this->client->request(
            'PATCH',
            '/' . $this->api['frontend'] . '/user/information/',
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
        $this->assertEmpty($result);

        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => $email]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEquals($user->getPhone(), $data['phone']);
        $this->assertEquals($user->getWebsite(), $data['website']);
        $this->assertEquals($user->getAbout(), $data['about']);
        $this->assertEquals($user->getFacebook(), $data['facebook']);
        $this->assertEquals($user->getTwitter(), $data['twitter']);
    }


    public function testRegisterUserAction()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password()
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
        $this->assertEmpty($content);

        $message = $this->getSwiftMailMessage();
        $this->assertEquals(UserMailManager::MAIL_ACCOUNT_NEW, $message->getSubject());
        $this->assertEquals($data['email'], key($message->getTo()));
        $this->assertEquals($this->websiteEmail, key($message->getFrom()));
        $this->assertNotNull($this->websiteEmail);
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
    }

    public function testUserForgotPasswordUserNotFoundActionFails()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/password/forgot/?email=notexists@aisel.co',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(403 === $statusCode);
        $this->assertEquals('User not found', $result['message']);
    }

    public function testUserForgotPasswordAction()
    {
        $mailTo = 'volgodark@gmail.com';
        $password = 'volgodark';

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/user/password/forgot/?email=' . $mailTo,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );


        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);

        // Check Message
        $message = $this->getSwiftMailMessage();
        $this->assertEquals(UserMailManager::MAIL_PASSWORD_NEW, $message->getSubject());
        $this->assertEquals($mailTo, key($message->getTo()));
        $this->assertEquals($this->websiteEmail, key($message->getFrom()));
        $this->assertNotNull($this->websiteEmail);

        // Login Fails
        $this->setExpectedException('LogicException');
        $this->logInFrontend($mailTo, $password);
    }

    public function testTerminateUserAccountAction()
    {
        $password = $this->faker->password();
        $email = $this->faker->email;

        $this->newUser($email, $password);
        $this->logInFrontend($email, $password);

        $this->client->request(
            'DELETE',
            '/' . $this->api['frontend'] . '/user-terminate/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($result);

        $message = $this->getSwiftMailMessage();
        $this->assertEquals(UserMailManager::MAIL_ACCOUNT_TERMINATE, $message->getSubject());
        $this->assertEquals($email, key($message->getTo()));
        $this->assertEquals($this->websiteEmail, key($message->getFrom()));
        $this->assertNotNull($this->websiteEmail);
    }

    public function testChangeUserPasswordAction()
    {
        $password = $this->faker->password();
        $email = $this->faker->email;
        $user = $this->newUser($email, $password);
        $oldPassword = $user->getPassword();

        $this->logInFrontend($email, $password);

        $newPassword = '000111222';
        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);
        $encodedPassword = $encoder->encodePassword(
            $newPassword,
            $user->getSalt()
        );

        $data = [
            'password' => $newPassword,
        ];

        $this->client->request(
            'PATCH',
            '/' . $this->api['frontend'] . '/user/password/change/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->em->clear();

        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => $email]);

        $this->assertTrue(204 === $statusCode);
        $this->assertNotEquals($oldPassword, $user->getPassword());
        $this->assertEquals($encodedPassword, $user->getPassword());
        $this->removeEntity($user);

        $message = $this->getSwiftMailMessage();
        $this->assertEquals(UserMailManager::MAIL_PASSWORD_NEW, $message->getSubject());
        $this->assertEquals($email, key($message->getTo()));
        $this->assertEquals($this->websiteEmail, key($message->getFrom()));
        $this->assertNotNull($this->websiteEmail);

        $this->logInFrontend($email, $newPassword);
    }

}

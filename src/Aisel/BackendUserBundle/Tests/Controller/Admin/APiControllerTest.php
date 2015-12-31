<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\BackendUserBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class APiControllerTest extends AbstractWebTestCase
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

    public function testPostUserAction()
    {
        $users = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findBy(['email' => 'test_backend_user_aisel@aisel.co']);

        foreach ($users as $user) {
            $this->em->remove($user);
        }
        $this->em->flush();

        $data = [
            'email' => 'test_backend_user_aisel@aisel.co',
            'plain_password' => 'test_backend_user_aisel',
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/backenduser/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/backenduser/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals($result['code'], 400);
        $this->assertEquals($result['errors']['email'], 'This value is already used.');
        $this->assertTrue(400 === $statusCode);
    }

    public function testGetUsersAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/backenduser/',
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

    public function testGetUserAction()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['email' => 'test_backend_user_aisel@aisel.co']);
        $id = $user->getId();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $user->getId());
    }

    public function testPutUserAction()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['email' => 'test_backend_user_aisel@aisel.co']);
        $id = $user->getId();
        $oldPassword = $user->getPassword();

        $passwordString = '000111222';
        $data['username'] = $passwordString; // todo : password updating doesn't work without this line
        $data['plain_password'] = $passwordString;

        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);
        $encodedPassword = $encoder->encodePassword(
            $passwordString,
            $user->getSalt()
        );

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $this->em->clear();

        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['email' => 'test_backend_user_aisel@aisel.co']);

        $this->assertNotEquals($oldPassword, $user->getPassword());
        $this->assertEquals($encodedPassword, $user->getPassword());
        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($user);
    }

    public function testDeleteUserAction()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['email' => 'test_backend_user_aisel@aisel.co']);
        $id = $user->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/backenduser/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $user = $this
            ->em
            ->getRepository('Aisel\BackendUserBundle\Entity\BackendUser')
            ->findOneBy(['email' => 'test_backend_user_aisel@aisel.co']);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($user);
    }

}

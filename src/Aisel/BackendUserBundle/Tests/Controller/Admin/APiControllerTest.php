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
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class APiControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetUsersAction()
    {
        $this->client->request(
            'GET',
            '/backend/api/backenduser/',
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
            ->findOneBy(['username' => 'backenduser']);
        $id = $user->getId();

        $this->client->request(
            'GET',
            '/backend/api/backenduser/' . $id,
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

    public function testPostUserAction()
    {
        $this->markTestSkipped('Test missing ..');
    }

    public function testPutUserAction()
    {
        $this->markTestSkipped('Test missing ..');
    }

    public function testDeleteUserAction()
    {
        $this->markTestSkipped('Test missing ..');
    }

}

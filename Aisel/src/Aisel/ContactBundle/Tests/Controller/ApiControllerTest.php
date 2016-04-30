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

use Aisel\ContactBundle\Manager\ContactManager;
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
            'name' => $this->faker->name,
            'email' => 'volgodark@mail.com',
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->text(400)
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/contact/form/',
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

        $message = $this->getSwiftMailMessage();
        $this->assertEquals(ContactManager::MAIL_CONTACT_FORM, $message->getSubject());
        $this->assertEquals($this->websiteEmail, key($message->getTo()));
        $this->assertEquals($data['email'], key($message->getFrom()));
        $this->assertNotNull($this->websiteEmail);
    }


    public function testContactPostActionFails()
    {
        $data = [
            'name' => $this->faker->name,
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/contact/form/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals(500, $statusCode);
        $this->assertEquals($result['message'], 'Undefined index: email');
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Tests\Controller\Admin;

use Aisel\AddressingBundle\Tests\AddressingWebTestCase;

/**
 * ApiRegionControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiRegionControllerTest extends AddressingWebTestCase
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

    public function testGetRegionsAction()
    {
        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/addressing/region/',
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

    public function testPostRegionAction()
    {
        $country = $this->newCountry();

        $data = array(
            'name' => 'AAA',
            'country' => array(
                'id' => $country->getId()),
        );

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/addressing/region/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $region = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(201 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($region);
        $this->assertEquals($data['name'], $region->getName());
        $this->assertEquals($data['country']['id'], $region->getCountry()->getId());
    }

    public function testGetRegionAction()
    {
        $region = $this->newRegion();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/addressing/region/' . $region->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $region->getId());
    }

    public function testPutRegionAction()
    {
        $country = $this->newCountry();
        $region = $this->newRegion();

        $id = $region->getId();
        $data = array(
            'country' => array('id' => $country->getId()),
        );

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/addressing/region/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $region = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEquals($data['country']['id'], $region->getCountry()->getId());
    }

    public function testDeleteRegionAction()
    {
        $region = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Region')
            ->findOneBy(['name' => 'AAA']);
        $id = $region->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/addressing/region/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $region = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Region')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEmpty($region);
    }

}

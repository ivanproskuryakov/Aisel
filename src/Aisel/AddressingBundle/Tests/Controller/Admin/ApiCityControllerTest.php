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
 * ApiCityControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiCityControllerTest extends AddressingWebTestCase
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

    public function testGetCitiesAction()
    {
        $city = $this->newCity();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/addressing/city/',
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


    public function testPostCityAction()
    {
        $region = $this->newRegion();

        $data = array(
            'name' => $this->faker->city,
            'region' => ['id' => $region->getId()],
        );

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/addressing/city/',
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
        $city = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(201 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($city);
        $this->assertEquals($region->getCountry()->getId(), $city->getRegion()->getCountry()->getId());
        $this->assertEquals($region->getId(), $city->getRegion()->getId());

        $this->removeEntity($city);
        $this->removeEntity($city->getRegion());
        $this->removeEntity($city->getRegion()->getCountry());
    }

    public function testGetCityAction()
    {
        $city = $this->newCity();

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/addressing/city/' . $city->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $city->getId());

    }

    public function testPutCityAction()
    {
        $region = $this->newRegion();
        $city = $this->newCity();
        $id = $city->getId();

        $data = array(
            'name' => 'Rivas',
            'region' => array('id' => $region->getId()),
        );

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/addressing/city/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $city = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEquals($region->getId(),$city->getRegion()->getId());
    }

    public function testDeleteCityAction()
    {
        $city = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\City')
            ->findOneBy(['name' => 'Rivas']);
        $id = $city->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/addressing/city/'. $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $city = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\City')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEmpty($city);
    }

}

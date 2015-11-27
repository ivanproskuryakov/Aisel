<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Tests\Controller;

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
            '/'. $this->api['frontend'] . '/addressing/city/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);

        $this->removeEntity($city);
        $this->removeEntity($city->getRegion());
        $this->removeEntity($city->getRegion()->getCountry());
    }

    public function testGetCityAction()
    {
        $city = $this->newCity();

        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/addressing/city/' . $city->getId(),
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

        $this->removeEntity($city);
        $this->removeEntity($city->getRegion());
        $this->removeEntity($city->getRegion()->getCountry());
    }

}

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
 * ApiCountryControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiCountryControllerTest extends AddressingWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetCountriesAction()
    {
        $country = $this->newCountry();

        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/addressing/country/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);

        $this->removeEntity($country);
    }

    public function testGetCountryAction()
    {
        $country = $this->newCountry();

        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/addressing/country/' . $country->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $country->getId());

        $this->removeEntity($country);
    }

}

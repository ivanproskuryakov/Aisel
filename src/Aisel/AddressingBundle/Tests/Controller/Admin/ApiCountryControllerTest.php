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

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;

/**
 * ApiCountryControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiCountryControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

//    public function testGetCountriesAction()
//    {
//        $this->client->request(
//            'GET',
//            '/'. $this->api['backend'] . '/addressing/country/',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json']
//        );
//
//        $response = $this->client->getResponse();
//        $content = $response->getContent();
//        $statusCode = $response->getStatusCode();
//
//        $this->assertTrue(200 === $statusCode);
//        $this->assertJson($content);
//    }
//
//    public function testPostCountryAction()
//    {
//        $data = array(
//            'iso2' => 'AA',
//            'iso3' => 'AAA',
//            'short_name' => 'A',
//            'long_name' => 'AA',
//            'calling_code' => '123',
//            'numcode' => '123',
//            'cctld' => '...',
//        );
//
//        $this->client->request(
//            'POST',
//            '/'. $this->api['backend'] . '/addressing/country/',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json'],
//            json_encode($data)
//        );
//
//        $response = $this->client->getResponse();
//        $content = $response->getContent();
//        $statusCode = $response->getStatusCode();
//        $parts = explode('/', $response->headers->get('location'));
//        $id = array_pop($parts);
//
//        $country = $this
//            ->em
//            ->getRepository('Aisel\AddressingBundle\Entity\Country')
//            ->find($id);
//
//        $this->assertTrue(201 === $statusCode);
//        $this->assertEmpty($content);
//        $this->assertNotNull($country);
//        $this->assertEquals($data['iso2'], $country->getIso2());
//        $this->assertEquals($data['iso3'], $country->getIso3());
//    }
//
//    public function testGetCountryAction()
//    {
//        $country = $this
//            ->em
//            ->getRepository('Aisel\AddressingBundle\Entity\Country')
//            ->findOneBy(['iso3' => 'AAA']);
//        $id = $country->getId();
//
//        $this->client->request(
//            'GET',
//            '/'. $this->api['backend'] . '/addressing/country/' . $id,
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json']
//        );
//
//        $response = $this->client->getResponse();
//        $content = $response->getContent();
//        $statusCode = $response->getStatusCode();
//        $result = json_decode($content, true);
//
//        $this->assertTrue(200 === $statusCode);
//        $this->assertEquals($result['id'], $country->getId());
//    }

    public function testPutCountryAction()
    {
        $country = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'RU']);
        $id = $country->getId();
        $data = array(
            'iso2' => 'ZZ',
        );
//        var_dump($country);
//        exit();

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/addressing/country/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        var_dump($content);
        exit();

        $this->em->clear();

        $country = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Country')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEquals($data['iso2'], $country->getIso2());
    }

    public function testDeleteCountryAction()
    {
        $country = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Country')
            ->findOneBy(['iso3' => 'AAA']);
        $id = $country->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/addressing/country/'. $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $country = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Country')
            ->find($id);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertEmpty($country);
    }

}

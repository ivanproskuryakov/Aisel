<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ProductControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostProductActionFails()
    {
        $data = [
            'locale' => 'en',
        ];

        $this->client->request(
            'POST',
            '/backend/api/product/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(count($result['errors']) > 0);
        $this->assertTrue(400 === $statusCode);
    }

//    public function testPostProductAction()
//    {
//        $data = [
//            'locale' => 'en',
//        ];
//
//        $this->client->request(
//            'POST',
//            '/backend/api/product/',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json'],
//            json_encode($data)
//        );
//
//        $response = $this->client->getResponse();
//        $content = $response->getContent();
//        $statusCode = $response->getStatusCode();
//        $result = json_decode($content, true);
//
//        $this->assertEmpty($content);
//        $this->assertTrue(201 === $statusCode);
//    }

    public function testGetProductAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Product')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/backend/api/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $product->getId());
    }

}

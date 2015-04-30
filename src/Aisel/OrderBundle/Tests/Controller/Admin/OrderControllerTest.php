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

    public function testGetOrdersAction()
    {
        $order = $this
            ->em
            ->getRepository('Aisel\OrderBundle\Entity\Order')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/backend/api/order/' . $order->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testGetProductAction()
    {
        $product = $this
            ->em
            ->getRepository('Aisel\OrderBundle\Entity\Order')
            ->findOneBy(['locale' => 'en']);

        $this->client->request(
            'GET',
            '/backend/api/order/' . $product->getId(),
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

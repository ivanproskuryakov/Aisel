<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Frontend;

use Aisel\ProductBundle\Tests\ProductWebTestCase;

/**
 * ApiReviewControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiReviewControllerTest extends ProductWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostReviewAction()
    {
        $product = $this->newProduct();

        $data = [
            'locale' => 'en',
            'name' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'subject' => ['id' => $product->getId()]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/en/product/review/',
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
    }

    public function testGetReviewAction()
    {
        $review = $this->newReview();

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/en/product/review/' . $review->getId(),
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


}

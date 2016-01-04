<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Controller\Frontend;

use Aisel\PageBundle\Tests\PageWebTestCase;

/**
 * ApiReviewControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiReviewControllerTest extends PageWebTestCase
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
        $page = $this->newPage();

        $data = [
            'locale' => 'en',
            'name' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'subject' => ['id' => $page->getId()]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['frontend'] . '/en/page/review/',
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
            '/' . $this->api['frontend'] . '/en/page/review/' . $review->getId(),
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

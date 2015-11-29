<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Controller;

use Aisel\ReviewBundle\Tests\ReviewWebTestCase;

/**
 * ApiReviewControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiReviewControllerTest extends ReviewWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGeReviewTreeAction()
    {
        $node = $this->newReviewNode();

        $this->client->request(
            'GET',
            '/'. $this->api['frontend'] . '/en/review/node/tree/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);

        $this->removeEntity($node);
    }

    public function testPostReviewAction()
    {
        $this->logInFrontend();
        $reviewNode = $this->newReviewNode();

        $data = [
            'locale' => 'en',
            'name' => $this->faker->title,
            'content' => $this->faker->sentence(10),
            'status' => true,
            'comment_status' => false,
            'nodes' => [
                [
                    'id' => $reviewNode->getId()
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/'. $this->api['frontend'] .'/en/review/',
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
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $review = $this
            ->em
            ->getRepository('Aisel\ReviewBundle\Entity\Review')
            ->find($id);

        $this->assertEquals($review->getNodes()[0]->getId(), $reviewNode->getId());

//        $this->removeEntity($review);
//        $this->removeEntity($reviewNode);
    }

}

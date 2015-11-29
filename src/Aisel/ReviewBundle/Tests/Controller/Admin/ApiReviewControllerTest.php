<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Controller\Admin;

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
        $this->logInBackend();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostReviewAction()
    {
        $reviewNode = $this->newReviewNode();
        $user = $this
            ->em
            ->getRepository('Aisel\FrontendUserBundle\Entity\FrontendUser')
            ->findOneBy(['username' => 'frontenduser']);

        $data = [
            'locale' => 'en',
            'name' => $this->faker->sentence(),
            'content' => $this->faker->sentence(),
            'status' => true,
            'meta_url' => 'metaUrl_' . time(),
            'meta_title' => 'metaTitle_' . time(),
            'comment_status' => false,
            'nodes' => [
                [
                    'id' => $reviewNode->getId()
                ]
            ],
            'frontenduser' => [ 'id' => $user->getId() ],
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['backend'] . '/review/',
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

    public function testGetReviewAction()
    {
        $review = $this->newReview();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/review/' . $review->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $review->getId());

//        $this->removeEntity($review);
    }

    public function testDeleteReviewAction()
    {
        $review = $this->newReview();
        $id = $review->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/review/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $review = $this
            ->em
            ->getRepository('Aisel\ReviewBundle\Entity\Review')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($review);
    }

    public function testPutReviewAction()
    {
        $review = $this->newReview();

        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/review/' . $review->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->em->clear();

        $review = $this
            ->em
            ->getRepository('Aisel\ReviewBundle\Entity\Review')
            ->findOneBy(['id' => $review->getId()]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($review);
        $this->assertEquals($data['locale'], $review->getLocale());
    }

}

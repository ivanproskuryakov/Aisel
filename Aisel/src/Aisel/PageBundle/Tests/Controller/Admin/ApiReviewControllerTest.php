<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Controller\Admin;

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
        $this->logInBackend();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetPageReviewAction()
    {
        $review = $this->newReview();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/page/review/' . $review->getId(),
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
    }

    public function testDeletePageReviewAction()
    {
        $review = $this->newReview();
        $id = $review->getId();

        $this->client->request(
            'DELETE',
            '/' . $this->api['backend'] . '/page/review/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $review = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Review')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($review);
    }

    public function testPutPageReviewAction()
    {
        $review = $this->newReview();
        $id = $review->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/page/review/' . $id,
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
            ->getRepository('Aisel\PageBundle\Entity\Review')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($review);
        $this->assertEquals($data['locale'], $review->getLocale());
    }


}

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

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;

/**
 * DuplicatedNodeTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class DuplicatedNodeTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostAction()
    {
        exit();
        $reviewNode = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'title' => $this->faker->sentence(1),
            'content' => $this->faker->paragraph(10),
            'status' => true,
            'meta_url' => 'metaUrl_' . $this->faker->numberBetween(100000, 900000),
            'meta_title' => 'metaTitle_' . $this->faker->numberBetween(100000, 900000),
            'comment_status' => false,
            'nodes' => [
                ['id' => $reviewNode->getId()],
                ['id' => $reviewNode->getId()],
            ]
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
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Review')
            ->find($id);

        $this->assertEquals($review->getNodes()[0]->getId(), $reviewNode->getId());
        $this->assertEquals(count($review->getNodes()), 1);
    }

}

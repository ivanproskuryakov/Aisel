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

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * DuplicatedNodeTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class DuplicatedNodeTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->logInSeller();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPostAction()
    {

        $pageNode = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'name' => $this->faker->sentence(1),
            'content' => $this->faker->paragraph(10),
            'status' => true,
            'meta_url' => 'metaUrl_' . $this->faker->numberBetween(100000, 900000),
            'meta_title' => 'metaTitle_' . $this->faker->numberBetween(100000, 900000),
            'comment_status' => false,
            'nodes' => [
                ['id' => $pageNode->getId()],
                ['id' => $pageNode->getId()],
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['seller'] . '/page/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertNotEmpty($content);
        $this->assertTrue(500 === $statusCode);
    }

}

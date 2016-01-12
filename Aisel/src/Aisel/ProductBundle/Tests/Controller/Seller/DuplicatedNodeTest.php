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
 * DuplicatedNodeTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class DuplicatedNodeTest extends AbstractWebTestCase
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

    public function testPostAction()
    {
        $productNode = $this
            ->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['locale' => 'en']);

        $data = [
            'locale' => 'en',
            'name' => $this->faker->sentence(1),
            'sku' => $this->faker->numberBetween(100000, 900000),
            'price' => $this->faker->numberBetween(1, 100),
            'content' => $this->faker->paragraph(10),
            'description_short' => $this->faker->paragraph(10),
            'status' => true,
            'meta_url' => 'metaUrl_' . $this->faker->numberBetween(100000, 900000),
            'meta_title' => 'metaTitle_' . $this->faker->numberBetween(100000, 900000),
            'comment_status' => false,
            'nodes' => [
                ['id' => $productNode->getId()],
                ['id' => $productNode->getId()],
            ]
        ];

        $this->client->request(
            'POST',
            '/' . $this->api['seller'] . '/product/',
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

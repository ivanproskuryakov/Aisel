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

    public function testPostPageAction()
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

        var_dump($content);
        exit();
        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);
    }

}

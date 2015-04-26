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
 * PageControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageControllerTest extends AbstractWebTestCase
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
            'title' => 'test',
            'content' => 'test',
            'status' => true,
            'meta_url' => 'metaUrl_'.time(),
            'meta_title' => 'metaTitle_'.time(),
            'comment_status' => false,
        ];

        $this->client->request(
            'POST',
            '/backend/api/page/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
//        var_dump($content);
//        exit();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);
    }

}

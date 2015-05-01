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
 * ApiNodeControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetPageNodesAction()
    {

        $this->markTestSkipped('Action is broken');

        $locale = reset($this->locales);
        $this->client->request(
            'GET',
            '/backend/api/page/category/?locale=' . $locale . '/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);
        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
    }

}

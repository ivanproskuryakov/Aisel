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

        $this->removeDocument($node);
    }

}

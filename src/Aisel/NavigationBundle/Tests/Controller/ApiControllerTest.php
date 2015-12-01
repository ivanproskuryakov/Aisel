<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Tests\Controller;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetNavigationAction()
    {
        $menu = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findBy(
                [
                    'locale' => 'en',
                    'status' => true,
                    "parent" => NULL
                ]
            );

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/en/navigation/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = json_decode($response->getContent(), true);
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($response->getContent());
        $this->assertEquals(count($menu), count($content));
    }

}

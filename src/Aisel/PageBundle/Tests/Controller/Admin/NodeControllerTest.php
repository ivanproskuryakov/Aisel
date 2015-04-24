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
 * NodeControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeControllerTest extends AbstractWebTestCase
{

    /**
     * @var array $locales
     */
    private $locales;

    public function setUp()
    {
        parent::setUp();
        $this->locales = explode("|", static::$kernel->getContainer()->getParameter('locales'));
    }

    protected function tearDown()
    {
        unset($this->locales);

        parent::tearDown();
    }

    public function testGetActorAction()
    {
        $this->client->request(
            'GET',
            '/backend/api/page/category/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);
        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);
        
        foreach($this->locales as $locale) {
            $this->assertNotEmpty($result[$locale]);
        }

    }

}

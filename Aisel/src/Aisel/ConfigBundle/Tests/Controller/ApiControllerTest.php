<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Tests\Controller;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiControllerTest extends AbstractWebTestCase
{

    /**
     * @var array
     */
    private $config = array();

    public function setUp()
    {
        parent::setUp();

        $this->config = static::$kernel->getContainer()->getParameter('aisel_config');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetConfigAction()
    {
        $locale = 'en';

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/en/config/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);

        $this->assertEquals($result['locale']['primary'], 'en');

        $collection = $this->em
            ->getRepository('Aisel\ConfigBundle\Entity\Config')
            ->getAllSettings($locale);

        foreach ($collection as $item) {
            $this->assertNotEmpty($result[$item['entity']]);
        }

        foreach ($result['locale']['available'] as $locale) {
            $this->assertNotFalse(array_search($locale, $this->locales));
        }
    }


    public function testGetBrokenConfigAction()
    {
        $locale = '0';

        $this->client->request(
            'GET',
            '/' . $this->api['frontend'] . '/' . $locale . '/config/'
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertJson($content);
        $this->assertTrue(200 === $statusCode);

        $this->assertEquals($result['locale']['primary'], 'en');

        $collection = $this->em
            ->getRepository('Aisel\ConfigBundle\Entity\Config')
            ->getAllSettings($locale);

        foreach ($collection as $item) {
            $this->assertNotEmpty($result[$item['entity']]);
        }

        foreach ($result['locale']['available'] as $locale) {
            $this->assertNotFalse(array_search($locale, $this->locales));
        }
    }

}

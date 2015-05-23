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
use JMS\Serializer\Annotation as JMS;
use Aisel\PageBundle\Entity\Category;

/**
 * ApiNodeEditControllerTest
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeEditControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function createCategory($name){
        $category = new Category();
        $category->setLocale('en');
        $category->setDescription('');
        $category->setMetaUrl('/');
        $category->setTitle($name);
        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    public function testPageNodeUpdateParentAction()
    {
        $category1 = $this->createCategory('AAA');
        $category2 = $this->createCategory('AAA');

        $this->client->request(
            'GET',
            '/backend/api/page/category/node/'.
            '?locale=en&action=dragDrop'.
            '&id='. $category1->getId().
            '&parentId='. $category2->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $category2->getId());
    }

    public function testPageNodeAddChildAction()
    {
        $category = $this->createCategory('AAA');

        $this->client->request(
            'GET',
            '/backend/api/page/category/node/'.
            '?locale=en'.
            '&action=addChild'.
            '&name=New+children'.
            '&parentId='. $category->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $category->getId());
    }

    public function testPageNodeChangeTitleAction()
    {
        $category = $this->createCategory('AAA');

        $this->client->request(
            'GET',
            '/backend/api/page/category/node/'.
            '?locale=en'.
            '&action=save'.
            '&name=BBB'.
            '&id='.$category->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['title'], 'BBB');
    }

    public function testPageNodeDeleteAction()
    {
        $category = $this->createCategory('ZZZZ');

        $this->client->request(
            'GET',
            '/backend/api/page/category/node/'.
            '?locale=en'.
            '&action=remove'.
            '&id='. $category->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Category')
            ->findOneBy(['title' => 'ZZZZ']);

        $this->assertTrue(200 === $statusCode);
        $this->assertNull($node);
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Tests\Controller\Admin;

use Aisel\ReviewBundle\Document\Node;
use Aisel\ReviewBundle\Tests\ReviewWebTestCase;

/**
 * ApiNodeEditControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeEditControllerTest extends ReviewWebTestCase
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

    public function testReviewNodeUpdateParentAction()
    {
        $parent = $this->newReviewNode();
        $child = $this->newReviewNode();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/review/node/node/' .
            '?locale=en&action=dragDrop' .
            '&id=' . $child->getId() .
            '&parentId=' . $parent->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();

        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $parent->getId());

        $this->dm->clear();

        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $result['id']]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());

        $parent = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $result['parent']['id']]);

        $this->removeDocument($parent);
    }

    public function testReviewNodeAddChildAction()
    {
        $parent = $this->newReviewNode();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/review/node/node/' .
            '?locale=en' .
            '&action=addChild' .
            '&name=New+children' .
            '&parentId=' . $parent->getId() . '',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['parent']['id'], $parent->getId());

        $this->dm->clear();

        $parent = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $parent->getId()]);

        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['id' => $result['id']]);
        $this->assertEquals($node->getParent()->getId(), $parent->getId());
        $this->assertEquals($node->getId(), $parent->getChildren()[0]->getId());

        $this->removeDocument($parent);
    }

    public function testReviewNodeChangeTitleAction()
    {
        $node = $this->newReviewNode();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/review/node/node/' .
            '?locale=en' .
            '&action=save' .
            '&name=BBB' .
            '&id=' . $node->getId(),
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

        $this->removeDocument($node);
    }

    public function testReviewNodeDeleteAction()
    {
        $node = $this->newReviewNode();

        $this->client->request(
            'GET',
            '/' . $this->api['backend'] . '/review/node/node/' .
            '?locale=en' .
            '&action=remove' .
            '&id=' . $node->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();

        $node = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Node')
            ->findOneBy(['title' => 'ZZZZ']);

        $this->assertTrue(200 === $statusCode);
        $this->assertNull($node);
    }

}

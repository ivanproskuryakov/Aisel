<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Tests\Controller\Admin;

use Aisel\NavigationBundle\Entity\Menu;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiDuplicateParentNodeControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiDuplicateParentNodeControllerTest extends AbstractWebTestCase
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

    public function createNode($name)
    {
        $node = new Menu();
        $node->setLocale('en');
        $node->setMetaUrl('/');
        $node->setName($name);
        $node->setStatus(true);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    public function testCascadeUpdateAction()
    {
        $this->markTestSkipped('JMS should not update parent values');

        $child = $this->createNode('Child');
        $parent = $this->createNode('Parent');

        $data = [
            'parent' => [
                'id' => $parent->getId(),
                'status' => false,
                'name' => $this->faker->randomNumber(),
                'meta_url' => $this->faker->randomNumber()
            ],
        ];

        $this->client->request(
            'PUT',
            '/' . $this->api['backend'] . '/navigation/' . $child->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );


        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEmpty($content);
        $this->assertTrue(204 === $statusCode);

        $this->em->clear();

        $node = $this
            ->em
            ->getRepository('Aisel\NavigationBundle\Entity\Menu')
            ->findOneBy(['id' => $child->getId()]);

        $this->assertEquals($parent->getId(), $node->getParent()->getId());
        $this->assertEquals($child->getId(), $node->getParent()->getChildren()[0]->getId());
        $this->assertEquals($node->getParent()->getName(), $data['parent']['name']);
        $this->assertEquals($node->getParent()->getStatus(), $data['parent']['status']);
        $this->assertEquals($node->getParent()->getMetaUrl(), $data['parent']['meta_url']);
    }

}

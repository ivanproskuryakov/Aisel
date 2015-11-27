<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\EventListener;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\ProductBundle\Entity\Node;

/**
 * ProductNodeUrlPersistenceListenerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductNodeUrlPersistenceListenerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDuplicatedUrlThrowsError()
    {
        $urlText = 'product-node-test-meta-url';
        $this->setExpectedException(
            'LogicException', 'Given URL already exists'
        );

        // Create Product Node 1
        $node1 = new Node();
        $node1->setLocale('en');
        $node1->setTitle('...');
        $node1->setDescription('...');
        $node1->setStatus(true);
        $node1->setMetaUrl($urlText);

        $this->em->persist($node1);
        $this->em->flush();

        // Create Product Node 2
        $node2 = new Node();
        $node2->setLocale('en');
        $node2->setTitle('...');
        $node2->setDescription('...');
        $node2->setStatus(true);
        $node2->setMetaUrl($urlText);

        $this->em->persist($node2);
        $this->em->flush();

        // Delete Product Node 1
        $node1 = $this->em
            ->getRepository('Aisel\ProductBundle\Entity\Node')
            ->findOneBy(['metaUrl' => $urlText]);

        $this->em->remove($node1);
        $this->em->flush();
    }

}

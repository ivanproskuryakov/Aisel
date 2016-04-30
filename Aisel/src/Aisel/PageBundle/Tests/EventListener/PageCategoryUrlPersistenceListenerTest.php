<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\EventListener;

use Aisel\PageBundle\Entity\Node;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * PageNodeUrlPersistenceListenerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageNodeUrlPersistenceListenerTest extends AbstractWebTestCase
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
        $urlText = 'page-node-test-meta-url';
        $this->setExpectedException(
            'LogicException', 'Given URL already exists'
        );

        // Create Page Node 1
        $node1 = new Node();
        $node1->setLocale('en');
        $node1->setName('...');
        $node1->setContent('...');
        $node1->setStatus(true);
        $node1->setMetaUrl($urlText);

        $this->em->persist($node1);
        $this->em->flush();
        $this->em->clear();

        // Create Page Node 2
        $node2 = new Node();
        $node2->setLocale('en');
        $node2->setName('...');
        $node2->setContent('...');
        $node2->setStatus(true);
        $node2->setMetaUrl($urlText);

        $this->em->persist($node2);
        $this->em->flush();

        // Delete Page Node 1
        $node1 = $this->em
            ->getRepository('Aisel\PageBundle\Entity\Node')
            ->findOneBy(['metaUrl' => $urlText]);

        $this->em->remove($node1);
        $this->em->flush();
        $this->em->clear();
    }

}

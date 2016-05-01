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

use Aisel\PageBundle\Entity\Page;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * PageUrlPersistenceListenerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageUrlPersistenceListenerTest extends AbstractWebTestCase
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
        $urlText = 'page-test-meta-url';

        $this->setExpectedException(
            'LogicException', 'Given URL already exists'
        );
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        // Create Page 1
        $page1 = new Page();
        $page1->setUser($user);
        $page1->setLocale('en');
        $page1->setContent('...');
        $page1->setName('...');
        $page1->setStatus(true);
        $page1->setMetaUrl($urlText);
        $page1->setMetaTitle('...');
        $page1->setCommentStatus(true);

        $this->em->persist($page1);
        $this->em->flush();
        $this->em->clear();

        // Create Page 2
        $page2 = new Page();
        $page2->setUser($user);
        $page2->setLocale('en');
        $page2->setContent('...');
        $page2->setName('...');
        $page2->setStatus(true);
        $page2->setMetaUrl($urlText);
        $page2->setMetaTitle('...');
        $page2->setCommentStatus(true);

        $this->em->persist($page2);
        $this->em->flush();

        // Delete Page 1
        $page1 = $this->em
            ->getRepository('Aisel\PageBundle\Entity\Page')
            ->findOneBy(['metaUrl' => $urlText]);

        $this->em->remove($page1);
        $this->em->flush();
        $this->em->clear();
    }

}

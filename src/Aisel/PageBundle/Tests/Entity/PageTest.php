<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Entity;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;
use Aisel\PageBundle\Entity\Page;
use Aisel\PageBundle\Entity\Node;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * PageTests
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageTests extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDuplicateNodes()
    {
        $this->setExpectedException(UniqueConstraintViolationException::class);

        $node = new Node();
        $node->setTitle($this->faker->title);
        $node->setStatus(true);
        $node->setDescription($this->faker->sentence(10));
        $node->setMetaUrl('url_' . time());
        $node->setLocale('en');

        $this->em->persist($node);
        $this->em->flush();

        $this->assertNotNull($node->getId());

        $page = new Page();
        $page->setLocale('en');
        $page->setTitle($this->faker->sentence(1));
        $page->setContent($this->faker->sentence(10));
        $page->setStatus(true);
        $page->setCommentStatus(true);
        $page->setMetaUrl('url_' . time());
        $page->addNode($node);
        $page->addNode($node);

        $this->em->persist($page);
        $this->em->flush();
    }

}

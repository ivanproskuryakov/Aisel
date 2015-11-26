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
use Aisel\ReviewBundle\Entity\Review;
use Aisel\ReviewBundle\Entity\Node as ReviewNode;

/**
 * PageReviewTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageReviewTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPageReview()
    {
        $this->markTestSkipped('skipping... ');
        $node = new ReviewNode();
        $node->setStatus(true);
        $node->setTitle($this->faker->sentence(1));
        $node->setDescription($this->faker->sentence(10));
        $node->setLocale('en');
        $this->em->persist($node);
        $this->em->flush();

        $review = new Review();
        $review->setTitle($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->addNode($node);
        $this->em->persist($review);
        $this->em->flush();

        $page = new Page();
        $page->setLocale('en');
        $page->setTitle($this->faker->sentence(1));
        $page->setContent($this->faker->sentence(10));
        $page->setStatus(true);
        $page->setCommentStatus(true);
        $page->setMetaUrl('url_' . time());
        $page->addReview($review);

        $this->em->persist($page);
        $this->em->flush();

        $this->assertNotNull($page->getId());
        $this->removeDocument($page);

        $review = $this
            ->em
            ->getRepository('Aisel\ReviewBundle\Entity\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNull($review);
    }

}

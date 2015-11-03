<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\Document;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;
use Aisel\PageBundle\Document\Page;
use Aisel\PageBundle\Document\Node;
use Aisel\ReviewBundle\Document\Review;
use Aisel\ReviewBundle\Document\Node as ReviewNode;

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

    public function testDuplicateNodes()
    {
        $node = new ReviewNode();
        $node->setStatus(true);
        $node->setTitle($this->faker->sentence(1));
        $node->setDescription($this->faker->sentence(10));
        $node->setLocale('en');
        $this->dm->persist($node);
        $this->dm->flush();

        $review = new Review();
        $review->setTitle($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->addNode($node);
        $this->dm->persist($review);
        $this->dm->flush();

        $page = new Page();
        $page->setLocale('en');
        $page->setTitle($this->faker->sentence(1));
        $page->setContent($this->faker->sentence(10));
        $page->setStatus(true);
        $page->setCommentStatus(true);
        $page->setMetaUrl('url_' . time());
        $page->addReview($review);


        $this->dm->persist($page);
        $this->dm->flush();

        $this->assertNotNull($page->getId());
        $this->removeDocument($page);

        $review = $this
            ->dm
            ->getRepository('Aisel\ReviewBundle\Document\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNull($review);
    }

}

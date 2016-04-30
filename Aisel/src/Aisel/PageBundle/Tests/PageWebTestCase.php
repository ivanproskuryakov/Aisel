<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests;

use Aisel\PageBundle\Entity\Node;
use Aisel\PageBundle\Entity\Page;
use Aisel\PageBundle\Entity\Review;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * PageWebTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageWebTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * newReview
     *
     * @return Page $page
     */
    public function newReview()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        $page = $this->newPage();

        $review = new Review();
        $review->setLocale('en');
        $review->setName($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setStatus(true);
        $review->setSubject($page);
        $review->setUser($user);

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    /**
     * newPage
     *
     * @return Page $page
     */
    public function newPage()
    {
        $user = $this
            ->em
            ->getRepository('Aisel\UserBundle\Entity\User')
            ->findOneBy(['email' => 'user@aisel.co']);

        $page = new Page();
        $page->setLocale('en');
        $page->setUser($user);
        $page->setName($this->faker->sentence(1));
        $page->setContent($this->faker->sentence(10));
        $page->setStatus(true);
        $page->setCommentStatus(true);
        $page->setMetaUrl('url_' . $this->faker->numberBetween(100000000, 9999999999));

        $this->em->persist($page);
        $this->em->flush();

        return $page;
    }

    /**
     * newNode
     *
     * @return Node $node
     */
    public function newNode()
    {
        $node = new Node();
        $node->setName($this->faker->sentence());
        $node->setStatus(true);
        $node->setLocale('en');
        $node->setMetaUrl($this->faker->sentence());

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }


}

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

use Aisel\PageBundle\Entity\Page;
use Aisel\PageBundle\Entity\Review;
use Aisel\PageBundle\Tests\PageWebTestCase;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * PageReviewTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageReviewTest extends PageWebTestCase
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
        $this->logInFrontend();
        $page = $this->newPage();

        $review = new Review();
        $review->setLocale('en');
        $review->setName($this->faker->sentence(1));
        $review->setContent($this->faker->sentence(10));
        $review->setSubject($page);
        $this->em->persist($review);
        $this->em->flush();

        $review = $this
            ->em
            ->getRepository('Aisel\PageBundle\Entity\Review')
            ->findOneBy(['id' => $review->getId()]);
        $this->assertNotNull($review);
    }

}

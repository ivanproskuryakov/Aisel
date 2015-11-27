<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests;

use Aisel\ProductBundle\Entity\Node;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * ProductWebTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductWebTestCase extends AbstractWebTestCase
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
     * newNode
     *
     * @return Node $node
     */
    public function newNode()
    {
        $node = new Node();
        $node->setTitle($this->faker->sentence());
        $node->setStatus(true);
        $node->setDescription($this->faker->sentence());
        $node->setLocale('en');
        $node->setMetaUrl($this->faker->sentence());

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }


}

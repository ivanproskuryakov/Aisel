<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FrontendUserBundle\Tests;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\FrontendUserBundle\Entity\FrontendUser;

/**
 * UserPersistenceTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserPersistenceTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testUserPasswordListener()
    {
        $user = new FrontendUser();
        $user->setUsername($this->faker->userName);
        $user->setEmail($this->faker->email);
        $user->setPlainPassword($this->faker->password());

        $this->em->persist($user);
        $this->em->flush();

        $this->assertNotEmpty($user->getId());
        $this->removeEntity($user);
    }
}

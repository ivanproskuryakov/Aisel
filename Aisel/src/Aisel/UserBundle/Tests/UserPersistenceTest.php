<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle\Tests;

use Aisel\UserBundle\Entity\User;
use Aisel\UserBundle\Tests\UserTestCase;

/**
 * UserPersistenceTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserPersistenceTest extends UserTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testUserPasswordAndGroupListener()
    {
        $password = $this->faker->password();
        $email = $this->faker->email;
        $user = $this->newUser($email, $password);

        $this->assertEquals($user->getRoles()[0], User::ROLE_USER);
        $this->assertNotEmpty($user->getId());
        $this->removeEntity($user);
    }
}

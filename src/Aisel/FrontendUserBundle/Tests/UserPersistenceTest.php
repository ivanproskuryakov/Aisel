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

use Aisel\FrontendUserBundle\Tests\FrontendUserTestCase;

/**
 * UserPersistenceTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserPersistenceTest extends FrontendUserTestCase
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
        $password = $this->faker->password();
        $username = $this->faker->userName;
        $user = $this->newFrontendUser($username, $password);

        $this->assertNotEmpty($user->getId());
        $this->removeEntity($user);
    }
}

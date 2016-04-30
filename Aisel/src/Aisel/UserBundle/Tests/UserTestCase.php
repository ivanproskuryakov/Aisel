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

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\UserBundle\Entity\User;
use Faker;

/**
 * UserTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UserTestCase extends AbstractWebTestCase
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
     * newUser
     *
     * @param string $email
     * @param string $password
     * @return User $user
     */
    public function newUser($email, $password)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPlainPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }


}

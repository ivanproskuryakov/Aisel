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

use Aisel\FrontendUserBundle\Entity\FrontendUser;
use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Faker;

/**
 * FrontendUserTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class FrontendUserTestCase extends AbstractWebTestCase
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
     * newFrontendUser
     *
     * @param string $email
     * @param string $password
     * @return FrontendUser $frontendUser
     */
    public function newFrontendUser($email, $password)
    {
        $user = new FrontendUser();
        $user->setEmail($email);
        $user->setPlainPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }


}

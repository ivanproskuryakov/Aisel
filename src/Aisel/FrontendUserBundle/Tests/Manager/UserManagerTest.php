<?php
/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AdminBundle\Tests\Manager;

use Aisel\ResourceBundle\PHPUnit\BaseTestCase;

/**
 * Url manipulations, check and return normilized RUL
 */
class UserManagerTest extends BaseTestCase
{

    /**
     * Is user authenticated
     *
     * @return null
     */
    public function testIsAuthenticated()
    {
        $frontendUserManager = $this->getService('frontend.user.manager');
        $auth = $frontendUserManager->isAuthenticated();
        $this->assertEquals(false, $auth);
    }

}

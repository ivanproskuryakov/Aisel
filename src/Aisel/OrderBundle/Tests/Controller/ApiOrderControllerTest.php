<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Tests\Controller;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;

/**
 * ApiOrderControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiOrderControllerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testLoginUserAction()
    {

        $this->markTestSkipped('... not finished');
        $loginStatus = $this->logInFrontend();

        var_dump($loginStatus);
        exit();

    }

}

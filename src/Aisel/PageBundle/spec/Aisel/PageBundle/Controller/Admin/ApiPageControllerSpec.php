<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\PageBundle\Controller\Admin;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiPageControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\Aisel\PageBundle\Controller\Admin\ApiPageController');
    }

}

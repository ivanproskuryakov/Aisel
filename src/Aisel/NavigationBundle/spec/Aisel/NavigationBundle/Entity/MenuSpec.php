<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\NavigationBundle\Entity;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MenuSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aisel\NavigationBundle\Entity\Menu');
    }

    function it_should_not_have_id()
    {
        $this->getId()->shouldReturn(null);
    }

}
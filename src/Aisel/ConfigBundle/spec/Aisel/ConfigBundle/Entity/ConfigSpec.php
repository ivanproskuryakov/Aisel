<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\ConfigBundle\Entity;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aisel\ConfigBundle\Entity\Config');
    }

    function it_should_not_have_id()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_should_not_have_locale()
    {
        $this->getLocale()->shouldReturn(null);
    }

    function it_should_not_have_value()
    {
        $this->getValue()->shouldReturn(null);
    }

}
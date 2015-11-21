<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\PageBundle\Entity;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Aisel\PageBundle\Entity\Page');
    }

    public function it_should_not_have_id()
    {
        $this->getId()->shouldReturn(null);
    }

}

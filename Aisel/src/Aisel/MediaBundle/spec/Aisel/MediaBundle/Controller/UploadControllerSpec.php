<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\MediaBundle\Controller;

use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UploadControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\Aisel\MediaBundle\Controller\UploadController');
    }

}

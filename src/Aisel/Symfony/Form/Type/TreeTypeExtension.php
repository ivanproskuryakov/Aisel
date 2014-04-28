<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\Symfony\Form\Type;

use Symfony\Component\Form\AbstractExtension;

/**
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class TreeTypeExtension extends AbstractExtension
{
    protected function loadTypes()
    {
        return array(
            new TreeType(),
        );
    }

    protected function loadTypeGuesser()
    {
        return new TreeTypeGuesser();
    }
}


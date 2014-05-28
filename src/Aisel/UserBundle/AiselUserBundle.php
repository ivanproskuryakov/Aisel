<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Aisel user bundle. Contains two different user entities for Frontend and Backend users.
 * Backend users based on FOSUser Bundle
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AiselUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}

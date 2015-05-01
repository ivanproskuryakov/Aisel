<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Controller\Admin;

use Aisel\AddressingBundle\Controller\ApiRegionController as BaseApiRegionController;

/**
 * ApiRegionController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiRegionController extends BaseApiRegionController
{

    protected $model = array(
        'class' => "Aisel\AddressingBundle\Entity\Region",
    );

}

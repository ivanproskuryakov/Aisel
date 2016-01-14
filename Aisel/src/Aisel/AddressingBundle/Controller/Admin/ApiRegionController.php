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

use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;

/**
 * ApiRegionController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiRegionController extends BaseApiController
{

    /**
     * @var string
     */
    protected $model = "Aisel\AddressingBundle\Entity\Region";

}

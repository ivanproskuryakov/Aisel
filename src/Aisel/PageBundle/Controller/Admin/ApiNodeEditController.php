<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller\Admin;

use Aisel\ResourceBundle\Controller\ApiNodeEditController as BaseApiNodeEditController;;

/**
 * ApiNodeEditController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeEditController extends BaseApiNodeEditController
{

    /**
     * @var string
     */
    protected $nodeManager = "aisel.pagenode.node.manager";

}

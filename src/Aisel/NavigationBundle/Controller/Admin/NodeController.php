<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Controller\Admin;

use Aisel\CategoryBundle\Controller\Admin\AbstractNodeController;

/**
 * Backend AJAX actions for navigation menu
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeController extends AbstractNodeController
{

    protected $nodeManager = "aisel.navigation.node.manager";

}

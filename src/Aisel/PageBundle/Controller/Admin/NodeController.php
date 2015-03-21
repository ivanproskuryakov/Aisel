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

use Aisel\CategoryBundle\Controller\Admin\AbstractNodeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Backend AJAX actions for page categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeController extends AbstractNodeController
{

    protected $nodeManager = "aisel.pagecategory.node.manager";

}

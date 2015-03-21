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

use Aisel\ResourceBundle\Controller\Admin\AbstractCollectionController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend Page REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiController extends AbstractCollectionController
{
    public $manager = "aisel.page.manager";
}

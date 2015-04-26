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

/**
 * PageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageController extends AbstractCollectionController
{
    protected $entity = "Aisel\PageBundle\Entity\Page";
    protected $route = "admin_api_aisel_page";
}

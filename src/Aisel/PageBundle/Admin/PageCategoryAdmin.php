<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Admin;

use Aisel\CategoryBundle\Admin\CategoryAdmin;

/**
 * Page Category CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageCategoryAdmin extends CategoryAdmin
{
    protected $baseRoutePattern = 'pagecategory';

}

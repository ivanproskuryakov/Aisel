<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Admin;

use Aisel\CategoryBundle\Admin\AbstractCategoryAdmin;

/**
 * Page Category CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductCategoryAdmin extends AbstractCategoryAdmin
{
    protected $baseRoutePattern = 'productcategory';

}

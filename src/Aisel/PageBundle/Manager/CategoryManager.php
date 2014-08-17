<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Manager;

use Aisel\CategoryBundle\Manager\AbstractCategoryManager;

class CategoryManager extends AbstractCategoryManager
{
    protected $categoryEntity = 'AiselPageBundle:Category';

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category REST API for User operations
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiUserCategoryController extends Controller
{

    /**
     * @Rest\View
     * /api/user/category/tree.json
     */
    public function categoryTreeAction(Request $request)
    {
        $categoryList = $this->container->get("aisel.pagecategory.manager")->getCategoryTree();

        return $categoryList;
    }

}

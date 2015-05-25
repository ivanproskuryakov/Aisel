<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Aisel\ResourceBundle\Controller\Admin\AbstractNodeController;

/**
 * Category REST API for Frontend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiNodeController extends AbstractNodeController
{

    /**
     * @var string
     */
    protected $model = "Aisel\ProductBundle\Entity\Category";

    /**
     * /api/product/category/list.json?limit=2&current=3
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $categoryList
     */
    public function categoryListAction(Request $request, $locale)
    {
        $params = array(
            'current' => $request->query->get('current'),
            'limit' => $request->query->get('limit'),
        );
        $categoryList = $this->container->get("aisel.productcategory.node.manager")->getCategories($params, $locale);

        return $categoryList;
    }

    /**
     * /api/product/category/view/{$$urlKey}.json
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $category
     */
    public function categoryViewAction($urlKey, $locale)
    {
        $category = $this->container->get("aisel.productcategory.node.manager")->getCategoryByUrl($urlKey, $locale);

        return $category;
    }

}

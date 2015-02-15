<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiProductController extends Controller
{

    /**
     * /backend/api/product/?limit=2&current=3
     *
     * @param Request $request
     * @param string $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getListAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'filter' => $request->get('filter')
        );

        $productList = $this->container->get("aisel.product.manager")->getProducts($params);
        return $productList;
    }

    /**
     * /backend/api/product/12
     *
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function getAction($id)
    {
        /** @var \Aisel\ProductBundle\Entity\Product $product */
        $product = $this->container->get("aisel.product.manager")->getProduct($id);

        return $product;
    }

}

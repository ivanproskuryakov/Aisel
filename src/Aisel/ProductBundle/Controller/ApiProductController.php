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

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiProductController extends Controller
{

    /**
     * @Rest\View
     * /api/product/list.json?limit=2&current=3
     */
    public function productListAction(Request $request)
    {
        $productList = false;
        return $productList;
    }

    /**
     * @Rest\View
     */
    public function productViewByURLAction($urlKey)
    {
        /** @var \Aisel\ProductBundle\Entity\Product $product */
        $product = $this->container->get("aisel.product.manager")->getProductByURL($urlKey);
        return $product;
    }
}

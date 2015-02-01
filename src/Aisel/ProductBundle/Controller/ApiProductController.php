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
     * /api/product/list.json?limit=2&current=3
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $list
     */
    public function productListAction(Request $request, $locale)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'locale' => $request->get('locale')
        );

        if ($request->get('user') && $this->isAuthenticated()) {
            $userid = $this->get('security.context')->getToken()->getUser()->getId();
            $params['userid'] = $userid;
        }
        $list = $this->container->get("aisel.product.manager")->getProducts($params, $locale);

        return $list;
    }

    /**
     * @param string $urlKey
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $product
     */
    public function productViewByURLAction($urlKey)
    {
        /** @var \Aisel\ProductBundle\Entity\Product $product */
        $product = $this->container->get("aisel.product.manager")->getProductByURL($urlKey);

        return $product;
    }
}

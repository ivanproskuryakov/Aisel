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

use Aisel\ResourceBundle\Controller\Admin\AbstractCollectionController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiProductController extends AbstractCollectionController
{

    protected $model = array(
        'class' => "Aisel\ProductBundle\Entity\Product",
    );

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

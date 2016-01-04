<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Controller\Seller;

use Aisel\ResourceBundle\Controller\ApiSellerController as BaseApiController;

/**
 * ApiProductController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiProductController extends BaseApiController
{

    /**
     * @var string
     */
    protected $model = "Aisel\ProductBundle\Entity\Product";

}

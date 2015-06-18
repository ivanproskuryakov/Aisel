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

/**
 * Frontend Product REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiProductController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $model = "Aisel\ProductBundle\Entity\Product";

}

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

use Aisel\ResourceBundle\Controller\Admin\AbstractCollectionController;

/**
 * ApiProductController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiProductController extends AbstractCollectionController
{

    /**
     * @var string
     */
    protected $entity = "Aisel\ProductBundle\Entity\Product";

}

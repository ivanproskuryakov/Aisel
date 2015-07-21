<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Document;

use Aisel\ResourceBundle\Repository\CollectionRepository;

/**
 * ProductRepository
 */
class ProductRepository extends CollectionRepository
{

    protected $model = 'AiselProductBundle:Product';

}

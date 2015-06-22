<?php

namespace Aisel\ProductBundle\Entity;

use Aisel\ResourceBundle\Repository\CollectionRepository;

/**
 * ProductRepository
 */
class ProductRepository extends CollectionRepository
{

    protected $model = 'AiselProductBundle:Product';

}

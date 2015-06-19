<?php

namespace Aisel\ProductBundle\Entity;

use Aisel\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * ProductRepository
 */
class ProductRepository extends AbstractCollectionRepository
{

    protected $model = 'AiselProductBundle:Product';

}

<?php

namespace Aisel\ProductBundle\Entity;

use Aisel\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * ProductRepository
 */
class ProductRepository extends AbstractCollectionRepository
{

    protected $model = 'AiselProductBundle:Product';

    /**
     * Get products filtered by category
     *
     * @param int $categoryId
     *
     * @return \Aisel\ProductBundle\Entity\Product $items
     */
    public function getProductsByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $items = $query->select('p.name, p.metaUrl, SUBSTRING(p.description, 1, 500) AS description,  p.createdAt')
            ->from($this->model, 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $items;
    }

}

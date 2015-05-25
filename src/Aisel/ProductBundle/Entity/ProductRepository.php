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
     * Get products based on limit, current pagination and search query
     *
     * @param array $params
     *
     * @return \Aisel\ProductBundle\Entity\Product
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from($this->model, 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale)
            ->andWhere('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /**
     * Get products based on limit, current pagination and search query
     *
     * @return \Aisel\ProductBundle\Entity\Product $items
     */
    public function getEnabledProducts()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $items = $query->select('p')
            ->from($this->model, 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $items;
    }

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

    /**
     * Find product by URL
     *
     * @param string   $url
     * @param int|null $productId
     *
     * @return int $found
     */
    public function findTotalByURL($url, $productId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(p.id)')
            ->from($this->model, 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($productId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId', $productId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

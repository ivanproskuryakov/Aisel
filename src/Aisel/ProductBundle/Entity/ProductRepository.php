<?php

namespace Aisel\ProductBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 */
class ProductRepository extends EntityRepository
{

    private $search = '';
    private $locale = null;
    private $category = 0;
    private $pageCurrent = 1;
    private $pageLimit = 1;
    private $pageSkip = 1;
    private $userId = null;
    private $pageOrder = 'id';
    private $pageOrderBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    private function mapRequest($params)
    {
        // Pagination
        if (isset($params['current'])) {
            $this->pageCurrent = $params['current'];
        } else {
            $this->pageCurrent = 1;
        }
        if (isset($params['limit'])) {
            $this->pageLimit = $params['limit'];
        } else {
            $this->pageLimit = 5;
        }
        if (isset($params['category'])) {
            $this->category = $params['category'];
        } else {
            $this->category = 0;
        }

        // Search
        if (isset($params['query'])) {
            $this->search = $params['query'];
        }
        // User
        if (isset($params['userid'])) {
            $this->userId = $params['userid'];
        }
        $this->locale = $params['locale'];
        $this->pageSkip = ($this->pageCurrent - 1) * $this->pageLimit;
    }

    /**
     * Get product total
     *
     * @param array $params
     *
     * @return int $total
     */
    public function getTotalFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(p.id)')
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.hidden != 1')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale);

        if ($this->category) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }

        if ($this->search != '') {
            $query->andWhere('p.description LIKE :search')->setParameter('search', '%' . $this->search . '%');
        }

        if ($this->userId) {
            $query->innerJoin('p.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        } else {
            $query->andWhere('p.status = :status')->setParameter('status', 1);
        }
        $total = $query->getQuery()->getSingleScalarResult();

        if (!$total) return 0;
        return $total;
    }

    /**
     * Get products based on limit, current pagination and search query
     *
     * @param  array $params
     *
     * @return \Aisel\ProductBundle\Entity\Product
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselProductBundle:Product', 'p')
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
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();
        return $items;
    }

    /**
     * Get products based on limit, current pagination and search query
     *
     * @param array $params
     *
     * @return \Aisel\ProductBundle\Entity\Product $products
     */
    public function getCurrentProductsFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('p.id,p.locale, p.name, p.price, p.metaUrl, SUBSTRING(p.description, 1, 500) AS description,  p.createdAt,  p.status,  p.mainImage')
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale);

        if ($this->userId) {
            $query
                ->innerJoin('p.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        } else {
            $query->andWhere('p.status = :status')->setParameter('status', 1);
        }

        if ($this->category) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }
        $items = $query->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();
        return $items;
    }

    /**
     * Get products filtered by category
     *
     * @param  int $categoryId
     *
     * @return \Aisel\ProductBundle\Entity\Product $items
     */
    public function getProductsByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $items = $query->select('p.name, p.metaUrl, SUBSTRING(p.description, 1, 500) AS description,  p.createdAt')
            ->from('AiselProductBundle:Product', 'p')
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
            ->from('AiselProductBundle:Product', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($productId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId', $productId);
        }
        $found = $query->getQuery()->getSingleScalarResult();
        return $found;
    }

}

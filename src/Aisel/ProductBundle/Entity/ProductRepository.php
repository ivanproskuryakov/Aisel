<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Product entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductRepository extends EntityRepository
{
    private $search = '';
    private $category = 0;
    private $productCurrent = 1;
    private $productLimit = 1;
    private $productSkip = 1;
    private $userId = null;
    private $productOrder = 'id';
    private $productOrderBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    private function mapRequest($params)
    {
        // Pagination
        if (isset($params['current'])) {
            $this->productCurrent = $params['current'];
        } else {
            $this->productCurrent = 1;
        }
        if (isset($params['limit'])) {
            $this->productLimit = $params['limit'];
        } else {
            $this->productLimit = 5;
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
        $this->productSkip = ($this->productCurrent - 1) * $this->productLimit;
    }

    /**
     * Get product total
     * @param  array $params
     * @return int   $total
     */
    public function getTotalFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.hidden != 1');

        if ($this->category) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }
        if ($this->search != '') {
            $query->andWhere('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%');
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
     * @param  array                         $params
     * @return \Aisel\ProductBundle\Entity\Product
     *                                              */
    public function searchFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselProductBundle:Product', 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->setMaxResults($this->productLimit)
            ->setFirstResult($this->productSkip)
            ->orderBy('p.' . $this->productOrder, $this->productOrderBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /**
     * Get products based on limit, current pagination and search query
     * @return \Aisel\ProductBundle\Entity\Product $products
     *                                       */
    public function getEnabledProducts()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $products = $query->select('p')
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $products;
    }

    /**
     * Get products based on limit, current pagination and search query
     * @param  array                         $params
     * @return \Aisel\ProductBundle\Entity\Product $products
     */
    public function getCurrentProductsFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('p.id, p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt,  p.status')
            ->from('AiselProductBundle:Product', 'p')
            ->andWhere('p.hidden != 1');

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

        $products = $query->setMaxResults($this->productLimit)
            ->setFirstResult($this->productSkip)
            ->orderBy('p.' . $this->productOrder, $this->productOrderBy)
            ->getQuery()
            ->execute();

        return $products;
    }

    /**
     * Get products filtered by category
     * @param  int                           $categoryId
     * @return \Aisel\ProductBundle\Entity\Product $products
     */
    public function getProductsByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $products = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from('AiselProductBundle:Product', 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $products;
    }

    /**
     * Find products by URL
     * @param  string $url
     * @param  int    $productId
     * @return int    $found
     */
    public function findTotalByURL($url, $productId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselProductBundle:Product', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($productId) {
            $query->andWhere('p.id != :productId')->setParameter('productId', $productId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

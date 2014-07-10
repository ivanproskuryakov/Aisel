<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Cart entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartRepository extends EntityRepository
{
    private $search = '';
    private $category = 0;
    private $cartCurrent = 1;
    private $cartLimit = 1;
    private $cartSkip = 1;
    private $userId = null;
    private $cartCart = 'id';
    private $cartCartBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    private function mapRequest($params)
    {
        // Pagination
        if (isset($params['current'])) {
            $this->cartCurrent = $params['current'];
        } else {
            $this->cartCurrent = 1;
        }
        if (isset($params['limit'])) {
            $this->cartLimit = $params['limit'];
        } else {
            $this->cartLimit = 5;
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
        $this->cartSkip = ($this->cartCurrent - 1) * $this->cartLimit;
    }

    /**
     * Get cart total
     * @param  array $params
     * @return int   $total
     */
    public function getTotalFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselCartBundle:Cart', 'p')
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
     * Get carts based on limit, current pagination and search query
     * @param  array $params
     * @return \Aisel\CartBundle\Entity\Cart
     *                                              */
    public function searchFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselCartBundle:Cart', 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->setMaxResults($this->cartLimit)
            ->setFirstResult($this->cartSkip)
            ->cartBy('p.' . $this->cartCart, $this->cartCartBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /**
     * Get carts based on limit, current pagination and search query
     * @return \Aisel\CartBundle\Entity\Cart $carts
     *                                       */
    public function getEnabledCarts()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $carts = $query->select('p')
            ->from('AiselCartBundle:Cart', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $carts;
    }

    /**
     * Get carts based on limit, current pagination and search query
     * @param  array $params
     * @return \Aisel\CartBundle\Entity\Cart $carts
     */
    public function getCurrentCartsFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('p.id, p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt,  p.status')
            ->from('AiselCartBundle:Cart', 'p')
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

        $carts = $query->setMaxResults($this->cartLimit)
            ->setFirstResult($this->cartSkip)
            ->cartBy('p.' . $this->cartCart, $this->cartCartBy)
            ->getQuery()
            ->execute();

        return $carts;
    }

    /**
     * Get carts filtered by category
     * @param  int $categoryId
     * @return \Aisel\CartBundle\Entity\Cart $carts
     */
    public function getCartsByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $carts = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from('AiselCartBundle:Cart', 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $carts;
    }

    /**
     * Find carts by URL
     * @param  string $url
     * @param  int $cartId
     * @return int    $found
     */
    public function findTotalByURL($url, $cartId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselCartBundle:Cart', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($cartId) {
            $query->andWhere('p.id != :cartId')->setParameter('cartId', $cartId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

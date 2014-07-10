<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Order entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderRepository extends EntityRepository
{
    private $search = '';
    private $category = 0;
    private $orderCurrent = 1;
    private $orderLimit = 1;
    private $orderSkip = 1;
    private $userId = null;
    private $orderOrder = 'id';
    private $orderOrderBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    private function mapRequest($params)
    {
        // Pagination
        if (isset($params['current'])) {
            $this->orderCurrent = $params['current'];
        } else {
            $this->orderCurrent = 1;
        }
        if (isset($params['limit'])) {
            $this->orderLimit = $params['limit'];
        } else {
            $this->orderLimit = 5;
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
        $this->orderSkip = ($this->orderCurrent - 1) * $this->orderLimit;
    }

    /**
     * Get order total
     * @param  array $params
     * @return int   $total
     */
    public function getTotalFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselOrderBundle:Order', 'p')
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
     * Get orders based on limit, current pagination and search query
     * @param  array $params
     * @return \Aisel\OrderBundle\Entity\Order
     *                                              */
    public function searchFromRequest($params)
    {

        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselOrderBundle:Order', 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->setMaxResults($this->orderLimit)
            ->setFirstResult($this->orderSkip)
            ->orderBy('p.' . $this->orderOrder, $this->orderOrderBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /**
     * Get orders based on limit, current pagination and search query
     * @return \Aisel\OrderBundle\Entity\Order $orders
     *                                       */
    public function getEnabledOrders()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $orders = $query->select('p')
            ->from('AiselOrderBundle:Order', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $orders;
    }

    /**
     * Get orders based on limit, current pagination and search query
     * @param  array $params
     * @return \Aisel\OrderBundle\Entity\Order $orders
     */
    public function getCurrentOrdersFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('p.id, p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt,  p.status')
            ->from('AiselOrderBundle:Order', 'p')
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

        $orders = $query->setMaxResults($this->orderLimit)
            ->setFirstResult($this->orderSkip)
            ->orderBy('p.' . $this->orderOrder, $this->orderOrderBy)
            ->getQuery()
            ->execute();

        return $orders;
    }

    /**
     * Get orders filtered by category
     * @param  int $categoryId
     * @return \Aisel\OrderBundle\Entity\Order $orders
     */
    public function getOrdersByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $orders = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from('AiselOrderBundle:Order', 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $orders;
    }

    /**
     * Find orders by URL
     * @param  string $url
     * @param  int $orderId
     * @return int    $found
     */
    public function findTotalByURL($url, $orderId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselOrderBundle:Order', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($orderId) {
            $query->andWhere('p.id != :orderId')->setParameter('orderId', $orderId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

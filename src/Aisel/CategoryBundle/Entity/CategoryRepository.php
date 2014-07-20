<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\Entity;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * Repository for Category entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CategoryRepository extends NestedTreeRepository
{

    private $pageCurrent = 1;
    private $pageLimit = 5;
    private $pageSkip = 1;

    private function mapRequest($params)
    {
        if (isset($params['current'])) {
            $this->pageCurrent = $params['current'];
        }

        if (isset($params['limit'])) {
            $this->pageLimit = $params['limit'];
        }

        $this->pageSkip = ($this->pageCurrent - 1) * $this->pageLimit;
    }

    /*
     * Get total active categories
     *
     * @return int value
     */

    public function getTotalFromRequest($params)
    {
        $this->mapRequest($params);

        $qb = $this->getEntityManager()->createQueryBuilder();

        $r = $qb->select('COUNT(c.id)')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.status = :status')
            ->setParameter('status', 1)
            ->getQuery()->getSingleScalarResult();

        if (!$r) return 0;
        return $r;
    }

    /*
     * Returns enabled categories
     *
     * @return object
     *                */

    public function getEnabledCategoryByUrl($urlKey)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $r = $qb->select('c')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.metaUrl = :metaUrl')->setParameter('metaUrl', $urlKey)
            ->andWhere('c.status = 1')
            ->getQuery()
            ->getSingleResult();

        return $r;
    }

    /*
     * Returns enabled categories
     *
     * @return object
     *                */

    public function getEnabledCategory($categoryId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $r = $qb->select('c')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->andWhere('c.status = 1')
            ->getQuery()
            ->getSingleResult();

        return $r;
    }

    /*
     * Returns enabled categories sorted as tree
     *
     * @return object
     *                */

    public function getCurrentCategoriesFromRequest($params)
    {
        $this->mapRequest($params);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $r = $qb->select('c')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.status = 1')
            ->addOrderBy('c.title', 'ASC')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->getQuery()
            ->execute();

        return $r;

    }

    /*
     * Returns enabled categories sorted as tree
     *
     * @return object
     *                */

    public function getEnabledCategoriesAsTree()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $r = $qb->select('c')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.status = 1')
            ->orderBy('c.root', 'ASC')
            ->addOrderBy('c.lft', 'ASC')
            ->getQuery()
            ->execute();

        return $r;
    }

    /*
     * Find categories by url
     *
     * @return int value
     */

    public function findTotalByURL($url, $categoryId = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('COUNT(c.id)')
            ->from('AiselCategoryBundle:Category', 'c')
            ->where('c.metaUrl = :url')->setParameter('url', $url);

        if ($categoryId) {
            $qb->andWhere('c.id != :categoryId')->setParameter('categoryId', $categoryId);
        }
        $found = $qb->getQuery()->getSingleScalarResult();

        return $found;
    }

}

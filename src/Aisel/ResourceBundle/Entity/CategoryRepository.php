<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Entity;

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

    protected $categoryEntity = 'AiselResourceBundle:Category';

    /**
     * Update vars with values from request
     *
     * @param array $params
     */
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

    /**
     * Get total active categories
     *
     * @param array $params
     * @param array $locale
     *
     * @return array|int $result
     */
    public function getTotalFromRequest($params, $locale)
    {
        $this->mapRequest($params);
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('COUNT(c.id)')
            ->from($this->categoryEntity, 'c')
            ->where('c.status = :status');

        if ($locale) {
            $query->andWhere('c.locale = :locale')->setParameter('locale', $locale);
        }
        $query
            ->setParameter('status', 1)
            ->getQuery()->getSingleScalarResult();
        $result = $query->getQuery()->getSingleScalarResult();

        if (!$result) return 0;
        return $result;
    }

    /**
     * Returns enabled categories
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @return array $result
     */
    public function getEnabledCategoryByUrl($urlKey, $locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('c')
            ->from($this->categoryEntity, 'c')
            ->where('c.metaUrl = :metaUrl')->setParameter('metaUrl', $urlKey)
            ->andWhere('c.locale = :locale')->setParameter('locale', $locale)
            ->andWhere('c.status = 1')
            ->getQuery()
            ->getSingleResult();

        return $result;
    }

    /**
     * Returns enabled categories
     *
     * @param int $categoryId
     *
     * @return array $result
     */
    public function getEnabledCategory($categoryId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('c')
            ->from($this->categoryEntity, 'c')
            ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->andWhere('c.status = 1')
            ->getQuery()
            ->getSingleResult();

        return $result;
    }

    /**
     * Returns enabled categories sorted as tree
     *
     * @param array $params
     * @param array $locale
     *
     * @return array $result
     */
    public function getCurrentCategoriesFromRequest($params, $locale)
    {
        $this->mapRequest($params);
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c')
            ->from($this->categoryEntity, 'c')
            ->where('c.status = 1');

        if ($locale) {
            $query->andWhere('c.locale = :locale')->setParameter('locale', $locale);
        }
        $query
            ->addOrderBy('c.title', 'ASC')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip);
        $result = $query->getQuery()->execute();

        return $result;

    }

    /**
     * Returns enabled categories sorted as tree
     *
     * @param string $locale
     *
     * @return array $result
     */
    public function getEnabledCategoriesAsTree($locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('c')
            ->from($this->categoryEntity, 'c')
            ->where('c.status = 1')
            ->andWhere('c.locale = :locale')->setParameter('locale', $locale)
            ->orderBy('c.root', 'ASC')
            ->addOrderBy('c.lft', 'ASC')
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * Find categories by url
     *
     * @param string   $url
     * @param int|null $categoryId
     *
     * @return int $result
     */
    public function findTotalByURL($url, $categoryId = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(c.id)')
            ->from($this->categoryEntity, 'c')
            ->where('c.metaUrl = :url')->setParameter('url', $url);

        if ($categoryId) {
            $qb->andWhere('c.id != :categoryId')->setParameter('categoryId', $categoryId);
        }
        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

}

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

use Doctrine\ORM\EntityRepository;

/**
 * AbstractCollectionRepository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractCollectionRepository extends EntityRepository
{

    protected $entity = '';
    protected $search = '';
    protected $locale = null;
    protected $filter = null;
    protected $category = 0;
    protected $pageCurrent = 1;
    protected $pageLimit = 1;
    protected $pageSkip = 1;
    protected $userId = null;
    protected $pageOrder = 'id';
    protected $pageOrderBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    protected function mapRequest(array $params)
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

        // Locale
        if (isset($params['locale'])) {
            $this->locale = $params['locale'];
        }

        // Filter
        if (isset($params['filter'])) {
            $this->filter = (array) json_decode($params['filter']);
        }
        $this->pageSkip = ($this->pageCurrent - 1) * $this->pageLimit;
    }

    /**
     * Get page total
     *
     * @param array $params
     *
     * @return int $total
     */
    public function getTotalFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(e.id)')
            ->from($this->entity, 'e');

        // === Filters ===
        if ($this->filter) {
            foreach ($this->filter as $k => $value) {
                $query->andWhere('e.' . $k . ' LIKE :' . $k)->setParameter($k, '%' . $value . '%');
            }
        }

        if ($this->locale) {
            $query->andWhere('e.locale = :locale')->setParameter('locale', $this->locale);
        }

        if ($this->category) {
            $query->innerJoin('e.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }

        if ($this->search != '') {
            $query->andWhere('e.content LIKE :search')->setParameter('search', '%' . $this->search . '%');
        }

        if ($this->userId) {
            $query->innerJoin('e.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        }

        $total = $query->getQuery()->getSingleScalarResult();

        if (!$total) {
            return 0;
        }

        return $total;
    }

    /**
     * Get products based on limit, current pagination and search query
     *
     * @param array $params
     *
     * @return mixed $collection
     */
    public function getCollectionFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('e')
            ->from($this->entity, 'e');

        // === Filters ===
        if ($this->filter) {
            foreach ($this->filter as $k => $value) {
                $query->andWhere('e.' . $k . ' LIKE :' . $k)->setParameter($k, '%' . $value . '%');
            }
        }

        if ($this->locale) {
            $query->andWhere('e.locale = :locale')->setParameter('locale', $this->locale);
        }

        if ($this->userId) {
            $query
                ->innerJoin('e.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        }

        if ($this->category) {
            $query->innerJoin('e.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }
        $collection = $query->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('e.' . $this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $collection;
    }

    // ---------------------------------
    // ---------- CATEGORIES -----------
    // ---------------------------------

    /**
     * Returns enabled categories sorted as tree
     *
     * @param string $locale
     * @param boolean $onlyEnabled
     *
     * @return array $result
     */
    public function getNodesAsTree($locale, $onlyEnabled = false)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('c')
            ->from($this->entity, 'c')
            ->where('c.status = :enabled')->setParameter('enabled', $onlyEnabled)
            ->andWhere('c.locale = :locale')->setParameter('locale', $locale)
            ->andWhere('c.lvl = :lvl')->setParameter('lvl', 0)
            ->orderBy('c.root', 'ASC')
            ->addOrderBy('c.lft', 'ASC')
            ->getQuery()
            ->execute();

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
            ->from($this->entity, 'c')
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
            ->from($this->entity, 'c')
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
            ->from($this->entity, 'c')
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
}

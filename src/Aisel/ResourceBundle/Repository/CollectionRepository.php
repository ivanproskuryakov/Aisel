<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CollectionRepository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CollectionRepository extends EntityRepository
{

    protected $model = '';
    protected $search = '';
    protected $locale = null;
    protected $filter = null;
    protected $category = 0;
    protected $pageCurrent = 1;
    protected $pageLimit = 1;
    protected $pageSkip = 1;
    protected $order = 'id';
    protected $orderBy = 'DESC';

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

        // Locale
        if (isset($params['locale'])) {
            $this->locale = $params['locale'];
        }

        // Locale
        if (isset($params['order'])) {
            $this->locale = $params['order'];
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
            ->from($this->model, 'e');

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
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder();
        $query->select('e')
            ->from($this->model, 'e');

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

        $collection = $query
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('e.' . $this->order, $this->orderBy)
            ->getQuery()
            ->execute();

        return $collection;
    }

    /**
     * Find pages by URL
     *
     * @param string $url
     * @param int    $entityId
     *
     * @return int $found
     */
    public function findTotalByURL($url, $entityId = null)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder();
        $query->select('e')
            ->from($this->model, 'e')
            ->where('e.metaUrl = :url')->setParameter('url', $url);

        if ($entityId) {
            $query->andWhere('e.id != :pageId')->setParameter('pageId', $entityId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

    // ---------------------------------
    // ---------- CATEGORIES -----------
    // ---------------------------------

    /**
     * Returns enabled categories sorted as tree
     *
     * @param string  $locale
     * @param boolean $onlyEnabled
     *
     * @return array $result
     */
    public function getNodesAsTree($locale, $onlyEnabled = true)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('c')
            ->from($this->model, 'c')
            ->where('c.lvl = :lvl')->setParameter('lvl', 0);

        if ($onlyEnabled) {
            $query->andWhere('c.status = :enabled')->setParameter('enabled', $onlyEnabled);
        }

        $result = $query
            ->andWhere('c.locale = :locale')->setParameter('locale', $locale)
            ->orderBy('c.root', 'ASC')
            ->addOrderBy('c.lft', 'ASC')
            ->getQuery()
            ->execute();

        return $result;
    }

}

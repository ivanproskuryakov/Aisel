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
    protected function mapRequest($params)
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

        if (!$total) return 0;
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

}

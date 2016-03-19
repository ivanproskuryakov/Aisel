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
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class CollectionRepository extends EntityRepository
{

    protected $model = '';
    protected $search = '';
    protected $locale = null;
    protected $filter = null;
    protected $node = 0;
    protected $pageCurrent = 1;
    protected $pageLimit = 1;
    protected $pageSkip = 1;
    protected $order = 'id';
    protected $orderBy = '';
    protected $user = null;

    /**
     * mapRequest
     *
     * @param array $params
     */
    protected function mapRequest(array $params)
    {
        $this->model = $this->getEntityName();

        // Pagination
        if (isset($params['current']) && $params['current'] > 0) {
            $this->pageCurrent = (int)$params['current'];
        } else {
            $this->pageCurrent = 1;
        }

        if (isset($params['limit']) && $params['limit'] > 0) {
            $this->pageLimit = (int)$params['limit'];
        } else {
            $this->pageLimit = 5;
        }

        if (isset($params['category'])) {
            $this->category = (int)$params['category'];
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
        // User
        if (isset($params['user'])) {
            $this->user = $params['user'];
        }
        // Order
        if (isset($params['order'])) {
            if (($params['order'] == 'ASC') || ($params['order'] == 'DESC')) {
                $this->order = $params['order'];
            }
        }
        // Order By
        if (isset($params['orderBy'])) {
            switch ($params['orderBy']) {
                case 'ASC':
                    $this->orderBy = 'ASC';
                    break;
                case 'DESC':
                    $this->orderBy = 'DESC';
                    break;
                default:
                    $this->orderBy = 'ASC';
            }
        }
        // Filter
        if (isset($params['filter'])) {
            $this->filter = (array)json_decode($params['filter']);
        }
        $this->pageSkip = ($this->pageCurrent - 1) * $this->pageLimit;
    }

    /**
     * getTotalFromRequest
     *
     * @param array $params
     *
     * @return int $total
     */
    public function getTotalFromRequest(array $params)
    {
        $this->mapRequest($params);

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder();

        $query->select('COUNT(e.id)')
            ->from($this->model, 'e');

        if ($this->filter) {
            foreach ($this->filter as $k => $value) {
                $query->andWhere('e.' . $k . ' LIKE :' . $k)->setParameter($k, '%' . $value . '%');
            }
        }

        if ($this->locale) {
            $query->andWhere('e.locale = :locale')->setParameter('locale', $this->locale);
        }

        if ($this->user) {
            $query->andWhere('e.user = :user')->setParameter('user', $this->user->getId());
        }

        if ($this->node) {
            $query->innerJoin('e.nodes', 'n')
                ->andWhere('n.metaUrl = :node')->setParameter('node', $this->node);
        }

        if ($params['scope'] == 'frontend') {
            $query->andWhere('e.status = :status')->setParameter('status', true);
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
     * getCollection
     *
     * @param array $params
     *
     * @return mixed $collection
     */
    public function getCollection(array $params)
    {
        $this->mapRequest($params);
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->model, 'e');

        if ($this->filter) {
            foreach ($this->filter as $k => $value) {
                $query->andWhere('e.' . $k . ' LIKE :' . $k)->setParameter($k, '%' . $value . '%');
            }
        }

        if ($this->locale) {
            $query->andWhere('e.locale = :locale')->setParameter('locale', $this->locale);
        }

        if ($this->user) {
            $query->andWhere('e.user = :user')->setParameter('user', $this->user->getId());
        }

        if ($this->node) {
            $query->innerJoin('e.nodes', 'c')
                ->andWhere('c.metaUrl = :node')->setParameter('node', $this->node);
        }

        if ($params['scope'] == 'frontend') {
            $query->andWhere('e.status = :status')->setParameter('status', true);
        }

        if ($this->search != '') {
            $query->andWhere('e.content LIKE :search')->setParameter('search', '%' . $this->search . '%');
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
     * findTotalByURL
     *
     * @param string $url
     * @param int $entityId
     * @return int $found
     */
    public function findTotalByURL($url, $entityId = null)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('e')
            ->from($this->model, 'e')
            ->where('e.metaUrl = :url')->setParameter('url', $url);

        if ($entityId) {
            $query->andWhere('e.id != :pageId')->setParameter('pageId', $entityId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

    /**
     * getCollectionAsTree
     *
     * @param array $params
     * @return array $result
     */
    public function getCollectionAsTree(array $params)
    {
        $this->model = $this->getEntityName();
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('n')
            ->from($this->model, 'n')
            ->where('n.parent IS NULL')
            ->andWhere('n.locale = :locale')->setParameter('locale', $params['locale']);

        if ($params['scope'] == 'frontend') {
            $query->andWhere('n.status = :status')->setParameter('status', true);
        }

        $result = $query
            ->orderBy('n.' . $this->order, $this->orderBy)
            ->getQuery()
            ->execute();

        return $result;
    }

}

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

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * CollectionRepository
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class CollectionRepository extends DocumentRepository
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
    protected $orderBy = '';

    /**
     * Map request variables for later use in SQL
     *
     * @param array $params
     */
    protected function mapRequest(array $params)
    {
        $this->model = $this->getDocumentName();

        // Pagination
        if (isset($params['current'])) {
            $this->pageCurrent =  (int) $params['current'];
        } else {
            $this->pageCurrent = 1;
        }

        if (isset($params['limit'])) {
            $this->pageLimit =  (int) $params['limit'];
        } else {
            $this->pageLimit = 5;
        }

        if (isset($params['category'])) {
            $this->category = (int) $params['category'];
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

        // Order
        if (isset($params['order'])) {
            $this->order = $params['order'];
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
        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder($this->model);

        if ($this->filter) {
            foreach ($this->filter as $field => $value) {
                $query->field($field)->equals($value);
            }
        }

        if ($this->locale) {
            $query->field('locale')->equals($this->locale);
        }

        if ($this->category) {
            $query->field('category')->equals($this->category);
        }

        if ($this->search != '') {
            $query->expr()->operator('content', array(
                    '$search' => $this->search,
                ));
        }

        $total = $query->count()
            ->getQuery()
            ->execute();

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
            ->getDocumentManager()
            ->createQueryBuilder($this->model);

        if ($this->filter) {
            foreach ($this->filter as $field => $value) {
                $query->field($field)->equals($value);
            }
        }

        if ($this->locale) {
            $query->field('locale')->equals($this->locale);
        }

        if ($this->category) {
            $query->field('category')->equals($this->category);
        }

        if ($this->search != '') {
            $query->expr()->operator('content', array(
                '$search' => $this->search,
            ));
        }

        $collection = $query
            ->limit($this->pageLimit)
            ->skip($this->pageSkip)
            ->sort($this->order, $this->orderBy)
            ->getQuery()
            ->toArray();

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
            ->getDocumentManager()
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
        $this->model = $this->getDocumentName();

        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder($this->model)
            ->field('parent')->exists(false)
            ->field('locale')->equals($locale);

        if ($onlyEnabled) {
            $query->field('status')->equals($onlyEnabled);
        }

        $result = $query
            ->sort($this->order, $this->orderBy)
            ->getQuery()
            ->toArray();

        return $result;
    }

}

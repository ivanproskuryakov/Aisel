<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Document;

use Aisel\ResourceBundle\Repository\CollectionRepository;
use Aisel\PageBundle\Document\Page;

/**
 * PageRepository
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageRepository extends CollectionRepository
{

    /**
     * Get pages based on limit, current pagination and search query
     *
     * @param  array $params
     * @return Page
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder($this->getDocumentName())
            ->field('status')->equals(true)
            ->field('locale')->equals($this->locale)
            ->field('content')->equals(new \MongoRegex('/.*' . $this->search . '.*/i'));

        $collection = $query
            ->limit($this->pageLimit)
            ->skip($this->pageSkip)
            ->sort($this->order, $this->orderBy)
            ->getQuery()
            ->toArray();

        return $collection;
    }

    /**
     * Get page total
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
            ->createQueryBuilder($this->model);

        if ($this->locale) {
            $query->field('locale')->equals($this->locale);
        }

        if ($this->search != '') {
            $query->field('content')->equals(new \MongoRegex('/.*' . $this->search . '.*/i'));
        }

        $query->field('status')->equals(true);
        $total = $query->count()
            ->getQuery()
            ->execute();

        if (!$total) {
            return 0;
        }

        return $total;
    }

}

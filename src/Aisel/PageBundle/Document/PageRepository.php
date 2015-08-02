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
     * @param  array                         $params
     * @return Page
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder($this->getDocumentName())
            ->field('status')->equals(true)
            ->field('locale')->equals($this->locale);

//        $query->expr()->operator('content', array(
//            '$search' => $this->search,
//        ));

        $collection = $query
            ->limit($this->pageLimit)
            ->skip($this->pageSkip)
            ->sort($this->order, $this->orderBy)
            ->getQuery()
            ->toArray();

        return $collection;
    }

    /**
     * Get pages based on limit, current pagination and search query
     * @return Page $pages
     */
    public function getEnabledPages()
    {
        $query = $this
            ->getDocumentManager($this->getDocumentName())
            ->createQueryBuilder();
        $pages = $query->select('p')
            ->from($this->model, 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $pages;
    }

}

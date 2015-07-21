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

/**
 * PageRepository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageRepository extends CollectionRepository
{

    protected $model = 'AiselPageBundle:Page';

    /**
     * Get pages based on limit, current pagination and search query
     * @param  array                         $params
     * @return \Aisel\PageBundle\Entity\Page
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p')
            ->from($this->model, 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale)
            ->andWhere('p.status = 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->order, $this->orderBy)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Get pages based on limit, current pagination and search query
     * @return \Aisel\PageBundle\Entity\Page $pages
     */
    public function getEnabledPages()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p')
            ->from($this->model, 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $pages;
    }

}

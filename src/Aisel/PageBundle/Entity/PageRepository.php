<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repositiry for Page enitity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageRepository extends EntityRepository
{
    private $query = '';
    private $pageCurrent = 1;
    private $pageLimit = 1;
    private $pageSkip = 1;
    private $pageOrder = 'id';
    private $pageOrderBy = 'DESC';

    private function mapRequest($params) {

        // Pagination
        if ( isset($params['current'])) {
            $this->pageCurrent = $params['current'];
        } else {
            $this->pageCurrent = 1;
        }
        if ( isset($params['limit'])) {
            $this->pageLimit = $params['limit'];
        } else {
            $this->pageLimit = 5;
        }

        // Search
        if ( isset($params['query'])) {
            $this->query = $params['query'];
        }
        $this->pageSkip = ($this->pageCurrent-1) * $this->pageLimit;
    }


    /*
     * Get page total
     *
     * @return int value
     * */

    public function getTotalFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.status = :status')
            ->andWhere('p.isHidden != 1');

        if ($this->query != '') {
            $query->andWhere('p.content LIKE :search')->setParameter('search', '%'.$this->query.'%');
        }
        $r = $query->setParameter('status', 1)
                ->getQuery()->getSingleScalarResult();

        if (!$r) return 0;
        return $r;
    }

    /*
     * Get pages based on limit, current pagination and search query
     *
     * @return pages
     * */

    public function searchFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%'.$this->query.'%')
            ->andWhere('p.status = 1')
            ->andWhere('p.isHidden != 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.'.$this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /*
     * Get pages based on limit, current pagination and search query
     *
     * @return array
     * */
    public function getEnabledPages()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselPageBundle:Page', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $r;
    }

    /*
     * Get pages based on limit, current pagination and search query
     *
     * @return pages
     * */

    public function getCurrentPagesFromRequest($params)
    {
        $this->mapRequest($params);

        $query = $this->getEntityManager()->createQueryBuilder();
        $r = $query->select('p')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.status = 1')
            ->andWhere('p.isHidden != 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.'.$this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $r;
    }

    /*
     * Get pages filtered by category
     *
     * @return pages
     * */

    public function getPagesByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $r = $query->select('p.title, p.metaUrl')
            ->from('AiselPageBundle:Page', 'p')
            ->innerJoin('p.categories','c')
            ->where('p.status = 1')
            ->andWhere('p.isHidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId',$categoryId)
            ->getQuery()
            ->execute();

        return $r;
    }

    /*
     * Find pages by url
     *
     * @return int value
     * */

    public function findTotalByURL($url, $pageId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($pageId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId',$pageId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }



}

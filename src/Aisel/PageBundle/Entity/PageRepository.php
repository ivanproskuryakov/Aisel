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
 * Repository for Page entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageRepository extends EntityRepository
{
    private $search = '';
    private $locale = null;
    private $category = 0;
    private $pageCurrent = 1;
    private $pageLimit = 1;
    private $pageSkip = 1;
    private $userId = null;
    private $pageOrder = 'id';
    private $pageOrderBy = 'DESC';

    /**
     * Map request variables for later use in SQL
     * @param array $params
     */
    private function mapRequest($params)
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
        $this->locale = $params['locale'];
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
        $query->select('COUNT(p.id)')
            ->from('AiselPageBundle:Page', 'p')
            ->andWhere('p.hidden != 1')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale);

        if ($this->category) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }

        if ($this->search != '') {
            $query->andWhere('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%');
        }

        if ($this->userId) {
            $query->innerJoin('p.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        } else {
            $query->andWhere('p.status = :status')->setParameter('status', 1);
        }

        $total = $query->getQuery()->getSingleScalarResult();

        if (!$total) return 0;
        return $total;
    }

    /**
     * Get pages based on limit, current pagination and search query
     * @param  array $params
     * @return \Aisel\PageBundle\Entity\Page
     */
    public function searchFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale)
            ->andWhere('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->pageOrder, $this->pageOrderBy)
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
            ->from('AiselPageBundle:Page', 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();
        return $pages;
    }

    /**
     * Get pages based on limit, current pagination and search query
     *
     * @param array $params
     *
     * @return \Aisel\PageBundle\Entity\Page $pages
     */
    public function getCurrentPagesFromRequest($params)
    {
        $this->mapRequest($params);
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('p.id,p.locale, p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt,  p.status')
            ->from('AiselPageBundle:Page', 'p')
            ->andWhere('p.hidden != 1')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale);

        if ($this->userId) {
            $query
                ->innerJoin('p.frontenduser', 'u')
                ->andWhere('u.id = :userid')->setParameter('userid', $this->userId);
        } else {
            $query->andWhere('p.status = :status')->setParameter('status', 1);
        }

        if ($this->category) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.metaUrl = :category')->setParameter('category', $this->category);
        }
        $pages = $query->setMaxResults($this->pageLimit)
            ->setFirstResult($this->pageSkip)
            ->orderBy('p.' . $this->pageOrder, $this->pageOrderBy)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Get pages filtered by category
     *
     * @param  int $categoryId
     *
     * @return \Aisel\PageBundle\Entity\Page $pages
     */
    public function getPagesByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from('AiselPageBundle:Page', 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('p.hidden != 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Find pages by URL
     *
     * @param  string $url
     * @param  int $pageId
     *
     * @return int    $found
     */
    public function findTotalByURL($url, $pageId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(p.id)')
            ->from('AiselPageBundle:Page', 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($pageId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId', $pageId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

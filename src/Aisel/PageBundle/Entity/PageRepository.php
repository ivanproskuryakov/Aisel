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

use Aisel\ResourceBundle\Entity\AbstractCollectionRepository;

/**
 * PageRepository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageRepository extends AbstractCollectionRepository
{

    protected $entity = 'AiselPageBundle:Page';

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
            ->from($this->entity, 'p')
            ->where('p.content LIKE :search')->setParameter('search', '%' . $this->search . '%')
            ->andWhere('p.locale = :locale')->setParameter('locale', $this->locale)
            ->andWhere('p.status = 1')
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
            ->from($this->entity, 'p')
            ->andWhere('p.status = 1')
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Get pages filtered by category
     *
     * @param int $categoryId
     *
     * @return \Aisel\PageBundle\Entity\Page $pages
     */
    public function getPagesByCategory($categoryId)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $pages = $query->select('p.title, p.metaUrl, SUBSTRING(p.content, 1, 500) AS content,  p.createdAt')
            ->from($this->entity, 'p')
            ->innerJoin('p.categories', 'c')
            ->where('p.status = 1')
            ->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->execute();

        return $pages;
    }

    /**
     * Find pages by URL
     *
     * @param string $url
     * @param int $pageId
     *
     * @return int $found
     */
    public function findTotalByURL($url, $pageId = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT(p.id)')
            ->from($this->entity, 'p')
            ->where('p.metaUrl = :url')->setParameter('url', $url);

        if ($pageId) {
            $query->andWhere('p.id != :pageId')->setParameter('pageId', $pageId);
        }
        $found = $query->getQuery()->getSingleScalarResult();

        return $found;
    }

}

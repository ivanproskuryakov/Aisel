<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Manager;

use LogicException;
use Aisel\ResourceBundle\Utility\UrlUtility;
use Aisel\PageBundle\Entity\Page;
use Doctrine\ORM\EntityManager;

/**
 * PageManager
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get categories in array for page
     *
     * @param Page $page
     *
     * @return array $categories
     */
    public function getPageCategories($page)
    {
        $categories = array();

        foreach ($page->getCategories() as $c) {
            $category = array();
            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $categories[$c->getId()] = $category;
        }

        return $categories;
    }

    /**
     * Get list of all pages
     *
     * @param array $params
     *
     * @return array
     */
    public function getCollection($params)
    {
        $total = $this->em->getRepository('AiselPageBundle:Page')->getTotalFromRequest($params);
        $collection = $this->em->getRepository('AiselPageBundle:Page')->getCollectionFromRequest($params);
        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

    /**
     * Get single detailed page with category by ID
     *
     * @param int $id
     *
     * @return mixed $pageDetails
     *
     * @throws LogicException
     */
    public function getItem($id)
    {
        $page = $this->getPageById($id);
        $pageDetails = array(
            'item' => $page,
            'categories' => $this->getPageCategories($page)
        );

        return $pageDetails;
    }

    /**
     * Delete Page
     *
     * @param int $id
     */
    public function deleteItem($id)
    {
        $page = $this->getPageById($id);
        $this->em->remove($page);
        $this->em->flush();
    }

    /**
     * Get single detailed page with category by URLKey
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @throws LogicException
     *
     * @return mixed $pageDetails
     */
    public function getPageByURL($urlKey, $locale)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findOneBy(array('metaUrl' => $urlKey));

        if (!$page) {
            throw new LogicException('Nothing found');
        }
        $pageDetails = array(
            'page' => $page,
            'categories' => $this->getPageCategories($page)
        );

        return $pageDetails;
    }

    /**
     * Load page by Id
     *
     * @param integer $id
     *
     * @throws LogicException
     *
     * @return Page $page
     */
    public function getPageById($id)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->find($id);

        if (!$page) {
            throw new LogicException('Nothing found');
        }

        return $page;
    }

    /**
     * Validate metaUrl for Page Entity and return one we can use
     *
     * @param string $url
     * @param int    $pageId
     *
     * @return string $validUrl
     */
    public function normalizePageUrl($url, $pageId = null)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findTotalByURL($url, $pageId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($page) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

    /**
     * Get List of all pages, except disabled
     *
     * @return string
     */
    public function getEnabledPages()
    {
        $pageList = $this->em->getRepository('AiselPageBundle:Page')->getEnabledPages();

        return $pageList;
    }

}

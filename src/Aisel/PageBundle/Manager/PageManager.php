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

/**
 * Manager for Pages, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageManager
{
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get categories in array for page
     *
     * @param int $page
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
     * @return \Aisel\PageBundle\Entity\Page $pageDetails
     *
     * @throws LogicException
     */
    public function getItem($id)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->find($id);

        if (!($page)) {
            throw new LogicException('Nothing found');
        }
        $pageDetails = array('item' => $page, 'categories' => $this->getPageCategories($page));

        return $pageDetails;
    }

    /**
     * Get single detailed page with category by URLKey
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @return \Aisel\PageBundle\Entity\Page $page
     *
     * @throws LogicException
     */
    public function getPageByURL($urlKey, $locale)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findOneBy(array('metaUrl' => $urlKey));

        if (!($page)) {
            throw new LogicException('Nothing found');
        }
        $pageDetails = array('page' => $page, 'categories' => $this->getPageCategories($page));

        return $pageDetails;
    }

    /**
     * validate metaUrl for Page Entity and return one we can use
     *
     * @param string $url
     * @param int $pageId
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

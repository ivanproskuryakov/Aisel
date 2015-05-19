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
    public function __construct(EntityManager $entityManager)
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
    public function getPageCategories(Page $page)
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
        $page = $this->em->getRepository('AiselPageBundle:Page')->findOneBy(
            array(
                'metaUrl' => $urlKey,
                'locale' => $locale
            )
        );

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

}

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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aisel\AdminBundle\Utility\UrlUtility;

class PageManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get list of all pages
     * @param array $params
     * @return array
     */
    public function getPages($params)
    {
        $total = $this->em->getRepository('AiselPageBundle:Page')->getTotalFromRequest($params);
        $pages = $this->em->getRepository('AiselPageBundle:Page')->getCurrentPagesFromRequest($params);

        $return = array (
            'total'=> $total,
            'pages'=> $pages
        );

        return $return;
    }

    /**
     * Get single detailed page with category by ID
     * @param int $id
     * @return mixed
     */
    public function getPage($id)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->find($id);

        if(!($page)){
            throw new NotFoundHttpException('Nothing found');
        }

        $pageDetails = array('page'=>$page,'categories'=>array());
        foreach ($page->getCategories() as $c) {
            $category = array();

            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $pageDetails['categories'][$c->getId()] = $category;

        }

        return $pageDetails;
    }

    /**
     * Get single detailed page with category by URLKey
     * @param int $id
     * @return mixed
     */
    public function getPageByURL($urlKey)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findOneBy(array('metaUrl' => $urlKey));

        if(!($page)){
            throw new NotFoundHttpException('Nothing found');
        }

        $pageDetails = array('page'=>$page,'categories'=>array());
        foreach ($page->getCategories() as $c) {
            $category = array();

            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $pageDetails['categories'][$c->getId()] = $category;

        }

        return $pageDetails;
    }


    /**
     * validate metaUrl for Page Entity and return one we can use
     * @return string
     */
    public function normalizePageUrl($url, $pageId = null)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findTotalByURL($url, $pageId);

        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($page) {
            $validUrl = $validUrl. '-1';
        }

        return $validUrl;
    }


}

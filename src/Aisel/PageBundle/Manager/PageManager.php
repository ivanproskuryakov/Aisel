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

class PageManager
{
    protected $sc;
    protected $em;

    public function __construct($sc,$em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get list of all pages
     * @return page object
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
     * Get single detailed page with category
     * @return mixed array
     */
    public function getPage($id)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->find($id);

        if(!($page)){
            throw $this->createNotFoundException();
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

}

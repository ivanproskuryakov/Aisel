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

/**
 * Manager for Pages, mostly used in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class UserPageManager
{
    protected $sc;
    protected $em;
    protected $securityContext;

    public function __construct($sc, $em, $securityContext)
    {
        $this->sc = $sc;
        $this->em = $em;
        $this->securityContext = $securityContext;
    }


    /**
     * Get single page for editing
     * @param int $pageId
     * @return \Aisel\PageBundle\Entity\Page $page
     */
    public function getPageById($pageId)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->find($pageId);

        if(!($page)){
            throw new NotFoundHttpException('Nothing found');
        }
//
//        $pageDetails = array('page'=>$page,'categories'=>array());
//        foreach ($page->getCategories() as $c) {
//            $category = array();
//
//            $category['id'] = $c->getId();
//            $category['title'] = $c->getTitle();
//            $category['url'] = $c->getMetaUrl();
//            $pageDetails['categories'][$c->getId()] = $category;
//
//        }

        return $page;
    }


}

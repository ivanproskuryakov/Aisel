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
use Aisel\PageBundle\Entity\Page;
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
    protected $pageManager;
    protected $userId;

    public function __construct($sc, $em, $securityContext, $pageManager)
    {
        $this->sc = $sc;
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->pageManager = $pageManager;

        if (!$this->isAuthenticated()) {
            throw new NotFoundHttpException('User not authenticated.');
        } else {
            $this->userId = $this->securityContext->getToken()->getUser()->getId();
        }
    }

    private function isAuthenticated()
    {
        if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN') === false) {
            return $this->securityContext->isGranted('ROLE_USER');
        }
        return false;
    }

    /**
     * Get single detailed page with category by URLKey
     * @param int $pageId
     * @return \Aisel\PageBundle\Entity\Page $page
     */
    public function getPageById($pageId)
    {
        $page = $this->em->getRepository('AiselPageBundle:Page')->findOneBy(
            array(
                'id' => $pageId,
                'frontenduser' => $this->userId,
            )
        );

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
     * Update page by given Id
     * @param int $pageId
     * @param array $details
     * @return $pageDetails
     */
    public function updatePageId($pageId, $details)
    {
        $jsonDetails = utf8_decode($details);
        $pageDetails = json_decode($jsonDetails);

        if (isset($pageDetails->page->title))               $page->setTitle($pageDetails->page->title);
        if (isset($pageDetails->page->content))             $page->setContent($pageDetails->page->content);
        if (isset($pageDetails->page->status))              $page->setStatus($pageDetails->page->status);
        if (isset($pageDetails->page->meta_title))          $page->setMetaTitle($pageDetails->page->meta_title);
        if (isset($pageDetails->page->meta_url))            $page->setMetaUrl($pageDetails->page->meta_url);
        if (isset($pageDetails->page->meta_keywords))       $page->setMetaKeywords($pageDetails->page->meta_keywords);
        if (isset($pageDetails->page->meta_description))    $page->setMetaKeywords($pageDetails->page->meta_description);
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        // url thing ..
        $url = $page->getMetaUrl();
        $normalUrl = $this->pageManager->normalizePageUrl($url);
        $page->setMetaUrl($normalUrl);

        $this->em->persist($page);
        $this->em->flush();


//        var_dump($page);
//        exit();
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

    /**
     * Add page
     * @param array $details
     * @return $pageDetails
     */
    public function addPage( $details)
    {
        $jsonDetails = utf8_decode($details);
        $pageDetails = json_decode($jsonDetails);

        $page = new Page();
        if (isset($pageDetails->page->title))               $page->setTitle($pageDetails->page->title);
        if (isset($pageDetails->page->content))             $page->setContent($pageDetails->page->content);
        if (isset($pageDetails->page->status))              $page->setStatus($pageDetails->page->status);
        if (isset($pageDetails->page->meta_title))          $page->setMetaTitle($pageDetails->page->meta_title);
        if (isset($pageDetails->page->meta_url))            $page->setMetaUrl($pageDetails->page->meta_url);
        if (isset($pageDetails->page->meta_keywords))       $page->setMetaKeywords($pageDetails->page->meta_keywords);
        if (isset($pageDetails->page->meta_description))    $page->setMetaKeywords($pageDetails->page->meta_description);
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        // url thing ..
        $url = $page->getMetaUrl();
        $normalUrl = $this->pageManager->normalizePageUrl($url);
        $page->setMetaUrl($normalUrl);

        $this->em->persist($page);
        $this->em->flush();
        return $page;
    }



}

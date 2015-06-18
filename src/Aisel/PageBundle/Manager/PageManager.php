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

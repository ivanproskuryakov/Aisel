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
     * Get list of all pages for cur
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


}

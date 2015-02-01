<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SearchBundle\Manager;

/**
 * Manager for search search in REST API
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SearchManager
{
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Get list of results
     *
     * @param array $params
     *
     * @return array $return
     */
    public function search($params)
    {
        $total = $this->em->getRepository('AiselPageBundle:Page')->getTotalFromRequest($params);
        $pages = $this->em->getRepository('AiselPageBundle:Page')->searchFromRequest($params);
        $return = array(
            'total' => $total,
            'pages' => $pages
        );

        return $return;
    }

}

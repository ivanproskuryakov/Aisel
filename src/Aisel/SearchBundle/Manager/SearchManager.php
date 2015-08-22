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

use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * SearchManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class SearchManager
{

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * Constructor
     *
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
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
        $pageRepository = $this->dm
            ->getRepository('AiselPageBundle:Page');

        $total = $pageRepository->getTotalFromRequest($params);
        $collection = $pageRepository->searchFromRequest($params);

        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

}

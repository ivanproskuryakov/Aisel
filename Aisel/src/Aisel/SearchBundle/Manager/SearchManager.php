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

use Doctrine\ORM\EntityManager;

/**
 * SearchManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class SearchManager
{

    /**
     * @var EntityManager
     */
    protected $dm;

    /**
     * Constructor
     *
     * @param EntityManager $dm
     */
    public function __construct(EntityManager $dm)
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
        $collection = $pageRepository->getCollection($params);

        $return = array(
            'total' => $total,
            'collection' => $collection
        );

        return $return;
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Entity;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * Repository for Menu entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class MenuRepository extends NestedTreeRepository
{

    /**
     * Get enabled menu items sorted as tree
     *
     * @param string $locale
     *
     * @return object
     */
    public function getEnabledMenuItems($locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $r = $qb->select('m')
            ->from('AiselNavigationBundle:Menu', 'm')
            ->where('m.status = 1')
            ->andWhere('m.locale = :locale')->setParameter('locale', $locale)
            ->orderBy('m.root', 'ASC')
            ->addOrderBy('m.lft', 'ASC')
            ->getQuery()
            ->execute();

        return $r;
    }

}

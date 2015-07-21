<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FrontendUserBundle\Document;

use Aisel\ResourceBundle\Repository\CollectionRepository;

/**
 * Frontend user repository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class FrontendUserRepository extends CollectionRepository
{
    protected $model = 'AiselFrontendUserBundle:FrontendUser';
//
//    /**
//     * Find user by Username and Email
//     *
//     * @param string $username
//     * @param string $email
//     *
//     * @return int value
//     */
//    public function findUser($username, $email)
//    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//
//        $qb->select('COUNT(u.id)')
//            ->from($this->model, 'u')
//            ->where('u.username = :username')
//            ->orWhere('u.email = :email')
//            ->setParameter('username', $username)
//            ->setParameter('email', $email);
//
//        $r = $qb->getQuery()->getSingleScalarResult();
//
//        return $r;
//    }

}

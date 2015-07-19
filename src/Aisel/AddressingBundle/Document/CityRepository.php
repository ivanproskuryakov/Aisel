<?php

namespace BrochureBundle\Document\Blog;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * CityRepository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CityRepository extends DocumentRepository
{
    public function findHomepage()
    {
        $qb = $this->createQueryBuilder();
        $qb->sort('createdAt', 'DESC');

        return $qb;
    }
}

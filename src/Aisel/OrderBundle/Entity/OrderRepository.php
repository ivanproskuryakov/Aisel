<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Order entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderRepository extends EntityRepository
{
    private $orderOrder = 'id';
    private $orderOrderBy = 'DESC';

}

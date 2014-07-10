<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Cart entity
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartRepository extends EntityRepository
{
    private $cartOrder = 'id';
    private $cartORderBy = 'DESC';

}

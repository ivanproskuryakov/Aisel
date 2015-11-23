<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\FrontendUserBundle\Entity;

use Aisel\ResourceBundle\Repository\CollectionRepository;

/**
 * Frontend user repository
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class FrontendUserRepository extends CollectionRepository
{

    protected $model = 'AiselFrontendUserBundle:FrontendUser';

}

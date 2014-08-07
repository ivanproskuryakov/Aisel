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

/**
 * Category Manager for user specific actions
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class UserCategoryManager
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

}

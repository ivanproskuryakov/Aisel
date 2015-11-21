<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Controller;

use Aisel\ResourceBundle\Controller\ApiController as BaseApiController;

/**
 * ApiReviewController
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiReviewController extends BaseApiController
{

    /**
     * @var string
     */
    protected $model = "Aisel\ReviewBundle\Entity\Review";

}

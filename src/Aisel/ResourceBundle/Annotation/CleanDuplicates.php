<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * CleanDuplicates
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @Annotation
 */
class CleanDuplicates extends Annotation
{

    public $name;

}

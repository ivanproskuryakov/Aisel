<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\CategoryBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

/**
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractCategoryManagerSpec extends ObjectBehavior
{

    function Let(Container $sc, EntityManager $em)
    {
        $this->beConstructedWith($sc, $em);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Aisel\CategoryBundle\Manager\AbstractCategoryManager');
    }
}
<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Aisel\ConfigBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use PhpSpec\ObjectBehavior;

/**
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SettingsControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aisel\ConfigBundle\Controller\SettingsController');
    }

    function let(ContainerInterface $container,
                 EngineInterface $templating
    )
    {
        $this->setContainer($container);
    }

    function it_should_respond_to_modify_action(EngineInterface $templating,
                                                Response $mockResponse)
    {
        $templating
            ->renderResponse(
                'AiselConfigBundle:Settings:layout.html.twig',
                array(array()),
                null
            )
            ->willReturn($mockResponse);
    }
}

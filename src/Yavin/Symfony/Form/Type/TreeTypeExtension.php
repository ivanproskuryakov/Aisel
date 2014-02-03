<?php

namespace Yavin\Symfony\Form\Type;

use Symfony\Component\Form\AbstractExtension;

class TreeTypeExtension extends AbstractExtension
{
    protected function loadTypes()
    {
        return array(
            new TreeType(),
        );
    }

    protected function loadTypeGuesser()
    {
        return new TreeTypeGuesser();
    }
}


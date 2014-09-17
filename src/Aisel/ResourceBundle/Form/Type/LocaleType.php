<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Locale form type, used for locale field in Sonata Admin
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LocaleType extends AbstractType
{
    private $locales;

    /**
     * {@inheritDoc}
     */
    public function __construct(array $options = array())
    {
        $locales = explode('|', $options['locales']);
        foreach ($locales as $locale) {
            $this->locales[$locale] = $locale;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->locales
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'aisel_locale';
    }

}

<?php

namespace Aisel\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for Disqus in Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigGeneralType extends AbstractType
{

    public $paymentMethods;

    public function __construct($options)
    {
        foreach ($options['payment_methods'] as $k => $v) {
            $this->paymentMethods[$k] = $v['title'];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency', 'text',
                array('label' => 'Currency label',
                    'attr' => array('class' => 'form-control'))
            )
            ->add('paymentMethods', 'choice', array(
                    'choices' => $this->paymentMethods,
                    'multiple' => true,
                )
            )
            ->add('save', 'submit',
                array('label' => 'Save',
                    'attr' => array('class' => 'btn btn-primary'))
            );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'config_general';
    }

}

<?php

namespace Aisel\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('someValue1', 'text', array('label' => 'Some Value 1'))
            ->add('someValue2', 'text', array('label' => 'Some Value 2'))
            ->add('someValue3', 'text', array('label' => 'Some Value 3'))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_category';
    }

}
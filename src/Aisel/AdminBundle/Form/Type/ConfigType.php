<?php

namespace Aisel\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('defaultMetaTitle', 'text', array('label' => 'Meta Keywords'))
            ->add('defaultMetaDescription', 'text', array('label' => 'Meta Description'))
            ->add('defaultMetaKeywords', 'text', array('label' => 'Meta Keywords'))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_meta';
    }

}
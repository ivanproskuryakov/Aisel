<?php

namespace Aisel\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('defaultMetaTitle', 'text', array('label' => 'Meta Title','attr' => array('class' => 'span12')))
            ->add('defaultMetaDescription', 'text', array('label' => 'Meta Description','attr' => array('class' => 'span12')))
            ->add('defaultMetaKeywords', 'text', array('label' => 'Meta Keywords','attr' => array('class' => 'span12')))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_meta';
    }

}
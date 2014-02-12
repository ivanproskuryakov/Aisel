<?php

namespace Aisel\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', 'text', array('label' => 'Name'))
            ->add('Email', 'email', array('label' => 'E-mail'))
            ->add('AddressLine1', 'text', array('label' => 'Address Line 1', 'attr'=> array( 'class'=>'span6')))
            ->add('AddressLine2', 'text', array('label' => 'Address Line 2', 'attr'=> array( 'class'=>'span6')))
            ->add('information', 'ckeditor', array('label' => 'Some Information' ))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_contact';
    }
}
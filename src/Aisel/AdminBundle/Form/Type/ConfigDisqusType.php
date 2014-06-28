<?php

namespace Aisel\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for Disqus in Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigDisqusType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('shortname', 'text', array('label' => 'Shortname','attr' => array('class'=>'form-control')))
            ->add('status', 'choice', array('choices'   => array(
                '0'   => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'Status','attr' => array('class'=>'form-control')
            ))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_meta';
    }

}

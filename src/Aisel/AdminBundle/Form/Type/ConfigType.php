<?php

namespace Aisel\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for META settings in Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('defaultMetaTitle', 'text', array('label' => 'Meta Title','attr' => array()))
            ->add('defaultMetaDescription', 'text', array('label' => 'Meta Description','attr' => array()))
            ->add('defaultMetaKeywords', 'text', array('label' => 'Meta Keywords','attr' => array()))
            ->add('save', 'submit', array('label' => 'Save', 'attr'=> array( 'class'=>'btn btn-primary')));

    }

    public function getName()
    {
        return 'config_meta';
    }

}

<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Address CRUD for backend administration
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AddressAdmin extends Admin
{
    protected $baseRoutePattern = 'addressing/address';
    protected $encoderFactory;

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('id')
            ->add('street')
            ->add('zip')
            ->add('country')
            ->add('region')
            ->add('city')
            ->add('frontenduser')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('phone', 'text', array('required' => true))
            ->with('aisel.default.dates')
            ->add('createdAt', 'datetime', array(
                'label' => 'aisel.default.created_at',
                'required' => false,
                'disabled' => true, 'attr' => array()))
            ->add('updatedAt', 'datetime', array(
                'label' => 'aisel.default.updated_at',
                'required' => false,
                'attr' => array()))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('phone')
            ->add('street')
            ->add('zip')
            ->add('comment')
            ->add('country')
            ->add('region')
            ->add('city')
            ->add('frontenduser');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('phone')
            ->add('street')
            ->add('zip')
            ->add('comment')
            ->add('country', null, array('label' => 'Country'))
            ->add('region', null, array('label' => 'Region'))
            ->add('city', null, array('label' => 'City'))
            ->add('frontenduser', null, array('label' => 'User'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($entity)
    {
        $entity->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($entity)
    {
        $entity->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getId() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }

}

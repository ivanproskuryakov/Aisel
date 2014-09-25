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
    public function validate(ErrorElement $errorElement, $object)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('phone', 'text', array('label' => 'aisel.addressing.phone', 'attr' => array()))
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
            ->add('phone', null, array('label' => 'aisel.addressing.phone'))
            ->add('street', null, array('label' => 'aisel.addressing.street'))
            ->add('zip', null, array('label' => 'aisel.addressing.zip'))
            ->add('comment', null, array('label' => 'aisel.addressing.comment'))
            ->add('country', null, array('label' => 'aisel.addressing.country'))
            ->add('region', null, array('label' => 'aisel.addressing.region'))
            ->add('city', null, array('label' => 'aisel.addressing.city'))
            ->add('frontenduser', null, array('label' => 'aisel.default.user'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('phone', null, array('label' => 'aisel.addressing.phone'))
            ->add('street', null, array('label' => 'aisel.addressing.street'))
            ->add('zip', null, array('label' => 'aisel.addressing.zip'))
            ->add('comment', null, array('label' => 'aisel.addressing.comment'))
            ->add('country', null, array('label' => 'aisel.addressing.country'))
            ->add('region', null, array('label' => 'aisel.addressing.region'))
            ->add('city', null, array('label' => 'aisel.addressing.city'))
            ->add('frontenduser', null, array('label' => 'aisel.default.user'))
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

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.general')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('street', null, array('label' => 'aisel.addressing.street'))
            ->add('zip', null, array('label' => 'aisel.addressing.zip'))
            ->add('country', null, array('label' => 'aisel.addressing.country'))
            ->add('region', null, array('label' => 'aisel.addressing.region'))
            ->add('city', null, array('label' => 'aisel.addressing.city'))
            ->add('frontenduser', null, array('label' => 'aisel.default.user'))
            ->with('aisel.default.dates')
            ->add('createdAt', null, array('label' => 'aisel.default.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'))
            ->end();
    }

}

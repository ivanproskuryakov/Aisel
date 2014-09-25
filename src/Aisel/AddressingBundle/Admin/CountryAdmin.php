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
 * Country CRUD for backend administration
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CountryAdmin extends Admin
{
    protected $baseRoutePattern = 'addressing/country';
    protected $encoderFactory;

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.general')
            ->add('iso2', null, array('label' => 'aisel.addressing.iso2'))
            ->add('iso3', null, array('label' => 'aisel.addressing.iso3'))
            ->add('shortName', null, array('label' => 'aisel.addressing.short_name'))
            ->add('cctld', null, array('label' => 'aisel.addressing.cctld'))
            ->with('aisel.default.dates')
            ->add('createdAt', null, array('label' => 'aisel.default.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'));
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
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id',
                'disabled' => true, 'required' => false,
                'attr' => array('class' => 'form-control')))
            ->add('iso2', 'text', array('label' => 'aisel.addressing.iso2', 'required' => true))
            ->add('iso3', 'text', array('label' => 'aisel.addressing.iso3', 'required' => true))
            ->add('cctld', 'text', array('label' => 'aisel.addressing.cctld', 'required' => true))
            ->add('shortName', 'text', array('label' => 'aisel.addressing.short_name', 'required' => true))
            ->add('longName', 'text', array('label' => 'aisel.addressing.long_name', 'required' => true))
            ->add('numcode', 'text', array('label' => 'aisel.addressing.numcode', 'required' => true))
            ->add('callingCode', 'text', array('label' => 'aisel.addressing.calling_code', 'required' => true))
            ->add('unMember', null, array('label' => 'aisel.addressing.un_member', 'required' => true))
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
            ->add('iso2', null, array('label' => 'aisel.addressing.iso2'))
            ->add('shortName', null, array('label' => 'aisel.addressing.short_name'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'aisel.default.id'))
            ->add('iso2', null, array('label' => 'aisel.addressing.iso2'))
            ->add('iso3', null, array('label' => 'aisel.addressing.iso3'))
            ->add('shortName', null, array('label' => 'aisel.addressing.short_name'))
            ->add('cctld', null, array('label' => 'aisel.addressing.cctld'))
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
    public function prePersist($user)
    {
        $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getIso2() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }

}

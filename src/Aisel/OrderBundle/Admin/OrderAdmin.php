<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\OrderBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Order CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class OrderAdmin extends Admin
{
    protected $orderManager;
    protected $baseRoutePattern = 'order';

    public function setManager($orderManager)
    {
        $this->orderManager = $orderManager;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertNotBlank()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('frontenduser', null, array('label' => 'aisel.default.user', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('totalamount', null, array('label' => 'aisel.order.total', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('status', 'text', array('label' => 'aisel.default.status', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->end()
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
     * {@inheritDoc}
     */
    public function prePersist($order)
    {
        $order->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */

    public function preUpdate($order)
    {
        $order->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'aisel.default.id'))
            ->add('frontenduser', null, array('label' => 'aisel.default.user'))
            ->add('status', 'text', array('label' => 'aisel.order.status', 'editable' => false))
            ->add('grandtotal', 'text', array('label' => 'aisel.order.total', 'editable' => false))
            ->add('createdAt', 'datetime', array('label' => 'aisel.default.created_at'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('status', 'test', array('label' => 'aisel.default.status'))
            ->end()
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
    public function toString($object)
    {
        return $object->getId() ? $object->getId() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

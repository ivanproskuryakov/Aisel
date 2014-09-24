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

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Order CRUD configuration for Backend
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class InvoiceAdmin extends Admin
{
    protected $orderManager;
    protected $baseRoutePattern = 'invoice';

    public function setManager($orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('id', 'integer', array('label' => 'Id','disabled' => true, 'attr' => array()))
            ->with('Dates')
            ->add('createdAt', 'datetime', array('label' => 'Created At','disabled' => true, 'attr' => array()))
            ->add('updatedAt', 'datetime', array('label' => 'Updated At', 'attr' => array()))
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
            ->addIdentifier('id')
            ->add('createdAt', 'datetime', array('label' => 'Created At'))
            ->add('updatedAt', 'datetime', array('label' => 'Updated At'))
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
            ->with('Information')
            ->add('id')
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

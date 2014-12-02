<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CartBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Cart CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CartAdmin extends Admin
{
    protected $cartManager;
    protected $baseRoutePattern = 'cart';

    public function setManager($cartManager)
    {
        $this->cartManager = $cartManager;
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
            ->add('product', null, array('label' => 'aisel.default.product', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
//            ->add('product', null,
//                array('label' => 'aisel.cart.products',
//                    'expanded' => true,
//                    'by_reference' => false, 'multiple' => true))
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
    public function prePersist($cart)
    {
        $cart->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $cart->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($cart)
    {
        $cart->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'aisel.default.id'))
            ->add('product', null, array('label' => 'aisel.cart.products'))
            ->add('frontenduser', null, array('label' => 'aisel.default.user'))
            ->add('createdAt', 'datetime', array('label' => 'aisel.default.created_at'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.information')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('products', null, array('label' => 'aisel.cart.products'))
            ->end()
            ->with('aisel.default.dates')
            ->add('createdAt', null, array('label' => 'aisel.default.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'));
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getId() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

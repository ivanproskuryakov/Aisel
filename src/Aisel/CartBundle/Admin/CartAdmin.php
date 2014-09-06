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
                ->add('products', null,
                array('label' => 'Products', 'expanded' => true,
                    'by_reference' => false, 'multiple' => true))
            ->with('Dates')
                ->add('createdAt', 'datetime', array('label' => 'Created At', 'attr' => array()))
                ->add('updatedAt', 'datetime', array('label' => 'Created At', 'attr' => array()))
            ->end();

    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    public function prePersist($cart)
    {
        $cart->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $cart->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function preUpdate($cart)
    {
        $cart->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('products')
            ->add('createdAt', 'datetime', array('label' => 'Created At'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Information')
            ->add('id');
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getId() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

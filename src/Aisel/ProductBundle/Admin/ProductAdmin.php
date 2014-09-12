<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Product CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ProductAdmin extends Admin
{
    protected $productManager;
    protected $baseRoutePattern = 'product';

    public function setManager($productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertNotBlank()
            ->end()
            ->with('descriptionShort')
            ->assertNotBlank()
            ->end()
            ->with('metaUrl')
            ->assertNotBlank()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->with('General')
            ->add('name', 'text', array('label' => 'Name', 'attr' => array()))
            ->add('sku', 'text', array('label' => 'Sku', 'attr' => array()))
//            ->add('status', 'choice', array('choices' => array(
//                '0' => 'Disabled',
//                '1' => 'Enabled'),
//                'label' => 'Status', 'attr' => array()))
//            ->add('descriptionShort', 'ckeditor',
//                array(
//                    'label' => 'Short Description',
//                    'required' => true,
//                    'attr' => array('class' => 'field-content')
//                ))
//            ->add('description', 'ckeditor',
//                array(
//                    'label' => 'Description',
//                    'required' => false,
//                    'attr' => array('class' => 'field-content')
//                ))

            ->with('Pricing')
            ->add('price', 'money', array('label' => 'Price', 'attr' => array()))
            ->add('priceSpecial', 'money', array('label' => 'Special Price', 'required' => false, 'attr' => array()))
            ->add('priceSpecialFrom', 'datetime', array('label' => 'Special Price From', 'attr' => array()))
            ->add('priceSpecialTo', 'datetime', array('label' => 'Special Price To', 'attr' => array()))
            ->add('new', 'choice', array('choices' => array(
                '0' => 'No',
                '1' => 'Yes'),
                'label' => 'New', 'attr' => array()))
            ->add('newFrom', 'datetime', array('label' => 'New From', 'attr' => array()))
            ->add('newTo', 'datetime', array('label' => 'New To', 'attr' => array()))
            ->with('Media')
                ->add('mainImage', 'iphp_file', array('label' => 'Main Image', 'required' => false, 'attr' => array('class'=>'mainImage')))
            ->with('Categories')
            ->add('categories', 'gedmotree', array('expanded' => true, 'multiple' => true,
                'class' => 'Aisel\ProductBundle\Entity\Category',
            ))
            ->with('Stock')
            ->add('manageStock', 'choice', array('choices' => array(
                '0' => 'No',
                '1' => 'Yes'),
                'label' => 'Use Stock', 'attr' => array()))
            ->add('inStock', 'choice', array('choices' => array(
                '0' => 'No',
                '1' => 'Yes'),
                'label' => 'In Stock', 'attr' => array()))
            ->add('qty', 'integer', array('label' => 'Qty', 'attr' => array()))
            ->with('Meta')
            ->add('metaUrl', 'text', array('label' => 'Url', 'required' => true, 'help' => 'note: URL value must be unique'))
            ->add('metaTitle', 'text', array('label' => 'Title', 'required' => false))
            ->add('metaDescription', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('metaKeywords', 'textarea', array('label' => 'Keywords', 'required' => false))
            ->with('Dates')
            ->add('createdAt', 'datetime', array('label' => 'Created At','disabled' => true, 'attr' => array()))
            ->add('updatedAt', 'datetime', array('label' => 'Updated At', 'attr' => array()))

            ->end();

    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    public function prePersist($product)
    {
        $url = $product->getMetaUrl();
        $normalUrl = $this->productManager->normalizeProductUrl($url);

        $product->setMetaUrl($normalUrl);
        $product->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $product->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function preUpdate($product)
    {
        $url = $product->getMetaUrl();
        $productId = $product->getId();
        $normalUrl = $this->productManager->normalizeProductUrl($url, $productId);

        $product->setMetaUrl($normalUrl);
        $product->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('mainImage','boolean', array('name' => 'Is published?', 'template' => 'AiselProductBundle:Media:list_field_image.html.twig'))
            ->add('name')
            ->add('sku')
            ->add('price')
            ->add('qty')
            ->add('new')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );;
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
            ->add('id')
            ->add('name')
            ->add('qty')
            ->add('inStock')
            ->add('description')
            ->add('descriptionShort')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('status', 'boolean')
            ->with('Categories')
            ->add('categories', 'tree')
            ->with('Meta')
            ->add('metaUrl')
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->with('Dates')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getSku() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

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

    /**
     * Pass product manager for later use
     */
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
        $subject = $this->getSubject();
        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('name', 'text', array('label' => 'aisel.default.name', 'attr' => array('class' => 'form-control')))
            ->add('sku', 'text', array('label' => 'aisel.default.sku', 'attr' => array('class' => 'form-control')))
            ->add('status', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.disabled'),
                '1' => $this->trans('aisel.default.enabled')),
                'required' => true,
                'label' => 'aisel.default.status', 'attr' => array('class' => 'form-control')))
            ->add('locale', 'aisel_locale', array('label' => 'aisel.default.locale',
                'required' => true,
                'attr' => array('class' => 'form-control')))
            ->add('descriptionShort', 'ckeditor',
                array(
                    'label' => 'aisel.default.short_description',
                    'required' => true,
                    'attr' => array('class' => 'field-content')
                ))
            ->add('description', 'ckeditor',
                array(
                    'label' => 'aisel.default.description',
                    'required' => false,
                    'attr' => array('class' => 'field-content')
                ))
            ->end()
            ->with('aisel.product.pricing')
            ->add('price', 'money', array('label' => 'aisel.product.price', 'attr' => array('class' => 'form-control')))
            ->add('priceSpecial', 'money', array('label' => 'aisel.product.special_price', 'required' => false, 'attr' => array()))
            ->add('priceSpecialFrom', 'datetime', array('label' => 'aisel.product.special_price_from', 'required' => false, 'attr' => array()))
            ->add('priceSpecialTo', 'datetime', array('label' => 'aisel.product.special_price_to', 'required' => false, 'attr' => array()))
            ->add('new', 'choice', array('choices' => array(
                    '0' => $this->trans('aisel.default.no'),
                    '1' => $this->trans('aisel.default.yes')),
                    'label' => 'aisel.default.new',
                    'required' => false,
                    'attr' => array('class' => 'form-control'))
            )
            ->add('newFrom', 'datetime', array('label' => 'aisel.default.new_from', 'required' => false, 'attr' => array()))
            ->add('newTo', 'datetime', array('label' => 'aisel.default.new_to', 'required' => false, 'attr' => array()))
            ->end()
            ->with('aisel.default.media')
            ->add('mainImage', 'iphp_file',
                array('label' => 'aisel.product.main_image',
                    'required' => false,
                    'attr' => array('class' => 'mainImage')))
            ->end()
            ->with('aisel.default.categories')
            ->add('categories', 'aisel_gedmotree', array(
                'expanded' => true,
                'multiple' => true,
                'class' => 'Aisel\ProductBundle\Entity\Category',
                'label' => 'aisel.default.categories',
                'query_builder' => function ($er) use ($subject) {
                        $qb = $er->createQueryBuilder('c');
                        if ($subject->getLocale()) {
                            $qb->where('c.locale = :locale')->setParameter('locale', $subject->getLocale());
                        }

                        return $qb;
                    }, 'empty_value' => $this->trans('aisel.default.no_parent')
            ))
            ->end()
            ->with('aisel.product.stock')
            ->add('manageStock', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.no'),
                '1' => $this->trans('aisel.default.yes')),
                'required' => false,
                'label' => 'aisel.product.use_stock',
                'attr' => array('class' => 'form-control')
            ))
            ->add('inStock', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.no'),
                '1' => $this->trans('aisel.default.yes')),
                'required' => false,
                'label' => 'aisel.product.in_stock',
                'attr' => array('class' => 'form-control')
            ))
            ->add('qty', 'integer', array(
                'label' => 'aisel.default.qty',
                'attr' => array('class' => 'form-control')))
            ->end()
            ->with('aisel.default.meta_data')
            ->add('metaUrl', 'text', array('label' => 'aisel.default.url',
                'required' => true,
                'help' => $this->trans('aisel.default.url_must_be_unique')))
            ->add('metaTitle', 'text', array('label' => 'aisel.default.title', 'required' => false))
            ->add('metaDescription', 'textarea', array('label' => 'aisel.default.description', 'required' => false))
            ->add('metaKeywords', 'textarea', array('label' => 'aisel.default.keywords', 'required' => false))
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
    public function prePersist($product)
    {
        $url = $product->getMetaUrl();
        $normalUrl = $this->productManager->normalizeProductUrl($url);

        $product->setMetaUrl($normalUrl);
        $product->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $product->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($product)
    {
        $url = $product->getMetaUrl();
        $productId = $product->getId();
        $normalUrl = $this->productManager->normalizeProductUrl($url, $productId);

        $product->setMetaUrl($normalUrl);
        $product->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('locale', 'aisel_locale', array('label' => 'aisel.default.locale',
                'required' => false,
                'attr' => array('class' => 'form-control')))
            ->add('mainImage', 'boolean', array('label' => 'aisel.product.main_image', 'template' => 'AiselProductBundle:Media:list_field_image.html.twig'))->add('name', null, array('label' => 'aisel.default.name'))
            ->add('sku', null, array('label' => 'aisel.default.sku'))
            ->add('price', null, array('label' => 'aisel.product.price'))
            ->add('qty', null, array('label' => 'aisel.default.qty'))
            ->add('new', null, array('label' => 'aisel.default.new'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.information')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('locale', null, array('label' => 'aisel.default.locale'))
            ->add('name', null, array('label' => 'aisel.default.name'))
            ->add('qty', null, array('label' => 'aisel.default.qty'))
            ->add('inStock', null, array('label' => 'aisel.default.description'))
            ->add('description', null, array('label' => 'aisel.default.description'))
            ->add('descriptionShort', null, array('label' => 'aisel.default.short_description'))
            ->add('status', 'boolean', array('label' => 'aisel.default.id'))
            ->end()
            ->with('aisel.default.categories')
            ->add('categories', 'tree', array('label' => 'aisel.default.categories'))
            ->end()
            ->with('aisel.default.meta_data')
            ->add('metaUrl', null, array('label' => 'aisel.default.url'))
            ->add('metaTitle', null, array('label' => 'aisel.default.meta_title'))
            ->add('metaDescription', null, array('label' => 'aisel.default.meta_description'))
            ->add('metaKeywords', null, array('label' => 'aisel.default.meta_keywords'))
            ->end()
            ->with('aisel.default.dates')
            ->add('createdAt', null, array('label' => 'aisel.default.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getSku() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

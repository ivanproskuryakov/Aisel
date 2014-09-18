<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Page CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class PageAdmin extends Admin
{
    protected $pageManager;
    protected $baseRoutePattern = 'page';

    public function setManager($pageManager)
    {
        $this->pageManager = $pageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('title')
            ->assertNotBlank()
            ->end()
            ->with('content')
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
            ->with('aisel.page.general')
            ->add('title', 'text', array('label' => 'aisel.page.title', 'attr' => array('class' => 'form-control')))
            ->add('content', 'ckeditor',
                array(
                    'label' => 'aisel.page.content',
                    'required' => true,
                    'attr' => array('class' => 'field-content')
                ))
            ->add('locale', 'aisel_locale', array('label' => 'aisel.page.locale', 'attr' => array('class' => 'form-control')))
            ->add('status', 'choice', array('choices' => array(
                '0' => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'aisel.page.status', 'attr' => array('required' => false, 'class' => 'form-control')
            ))
            ->add('commentStatus', 'choice', array('choices' => array(
                '0' => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'aisel.page.comments', 'attr' => array('class' => 'form-control')))
            ->add('hidden', null, array('required' => false, 'label' => 'aisel.page.hidden_page','attr' => array('class' => 'form-control')))
            ->add('frontenduser', null, array('label' => 'aisel.page.user'))

            ->with('aisel.page.categories')
            ->add('categories', 'aisel_gedmotree', array('expanded' => true, 'multiple' => true,
                'class' => 'Aisel\PageBundle\Entity\Category',
                'label' => 'aisel.page.categories',
                'attr' => array('class' => '')
            ))
            ->with('aisel.page.meta_data')
            ->add('metaUrl', 'text', array('label' => 'aisel.page.url','required' => true, 'help' => 'note: URL value must be unique'))
            ->add('metaTitle', 'text', array('label' => 'aisel.page.meta_title','required' => false))
            ->add('metaDescription', 'textarea', array('label' => 'aisel.page.meta_description','required' => false))
            ->add('metaKeywords', 'textarea', array('label' => 'aisel.page.meta_keywords','required' => false))
            ->with('aisel.page.dates')
            ->add('createdAt', 'datetime', array('label' => 'aisel.page.created_at','required' => false, 'disabled' => true, 'attr' => array()))
            ->add('updatedAt', 'datetime', array('label' => 'aisel.page.updated_at','required' => false, 'attr' => array()))
            ->end();

    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'aisel.page.title'))
            ->add('content', null, array('label' => 'aisel.page.content'))
            ->add('locale', null, array('label' => 'aisel.page.locale', 'field_type' => 'aisel_locale', 'attr' => array()));
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($page)
    {
        $url = $page->getMetaUrl();
        $normalUrl = $this->pageManager->normalizePageUrl($url);

        $page->setMetaUrl($normalUrl);
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }
    /**
     * {@inheritDoc}
     */
    public function preUpdate($page)
    {
        $url = $page->getMetaUrl();
        $pageId = $page->getId();
        $normalUrl = $this->pageManager->normalizePageUrl($url, $pageId);

        $page->setMetaUrl($normalUrl);
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'aisel.page.id'))
            ->add('title', null, array('label' => 'aisel.page.title'))
            ->add('frontenduser', null, array('label' => 'aisel.page.user'))
            ->add('status', 'boolean', array('label' => 'aisel.page.status', 'editable' => false))
            ->add('locale', 'text', array('label' => 'aisel.page.locale'))
            ->add('updatedAt', 'datetime', array('label' => 'aisel.page.updated_at'))
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
            ->with('aisel.page.information')
            ->add('id', null, array('label' => 'aisel.page.id'))
            ->add('content', null, array('label' => 'aisel.page.content'))
            ->add('user', null, array('label' => 'aisel.page.user'))
            ->add('status', 'boolean', array('label' => 'aisel.page.id'))
            ->with('aisel.page.categories')
            ->add('categories', 'tree', array('label' => 'aisel.page.id'))
            ->with('aisel.page.meta_data')
            ->add('metaUrl', null, array('label' => 'aisel.page.url'))
            ->add('metaTitle', null, array('label' => 'aisel.page.meta_title'))
            ->add('metaDescription', null, array('label' => 'aisel.page.meta_description'))
            ->add('metaKeywords', null, array('label' => 'aisel.page.meta_keywords'))
            ->with('aisel.page.dates')
            ->add('createdAt', null, array('label' => 'aisel.page.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.page.updated_at'));

    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

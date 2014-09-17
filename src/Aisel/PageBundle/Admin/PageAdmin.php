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
            ->add('title', 'text', array('label' => 'aisel.page.title', 'attr' => array()))
            ->add('content', 'ckeditor',
                array(
                    'label' => 'aisel.page.content',
                    'required' => true,
                    'attr' => array('class' => 'field-content')
                ))
            ->add('status', 'choice', array('choices' => array(
                '0' => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'aisel.page.status', 'attr' => array()
            ))
            ->add('commentStatus', 'choice', array('choices' => array(
                '0' => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'aisel.page.comments', 'attr' => array()
            ))
            ->add('hidden', null, array('required' => false, 'label' => 'aisel.page.hidden_page'))
            ->add('frontenduser', null, array('label' => 'aisel.page.user'))

            ->with('aisel.page.categories')
            ->add('categories', 'gedmotree', array('expanded' => true, 'multiple' => true,
                'class' => 'Aisel\PageBundle\Entity\Category',
                'label' => 'aisel.page.categories'
            ))
            ->with('aisel.page.metadata')
            ->add('metaUrl', 'text', array('label' => 'aisel.page.url','required' => true, 'help' => 'note: URL value must be unique'))
            ->add('metaTitle', 'text', array('label' => 'aisel.page.title','required' => false))
            ->add('metaDescription', 'textarea', array('label' => 'aisel.page.description','required' => false))
            ->add('metaKeywords', 'textarea', array('label' => 'aisel.page.keywords','required' => false))
            ->with('aisel.page.dates')
            ->add('createdAt', 'datetime', array('label' => 'aisel.page.created_at','disabled' => true, 'attr' => array()))
            ->add('updatedAt', 'datetime', array('label' => 'aisel.page.updated_at', 'attr' => array()))

            ->end();

    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('content');
    }

    public function prePersist($page)
    {
        $url = $page->getMetaUrl();
        $normalUrl = $this->pageManager->normalizePageUrl($url);

        $page->setMetaUrl($normalUrl);
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function preUpdate($page)
    {
        $url = $page->getMetaUrl();
        $pageId = $page->getId();
        $normalUrl = $this->pageManager->normalizePageUrl($url, $pageId);

        $page->setMetaUrl($normalUrl);
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('frontenduser', null, array('label' => 'User'))
            ->add('status', 'boolean', array('label' => 'Status', 'editable' => false))
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
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Information')
            ->add('id')
            ->add('content')
            ->add('frontenduser')
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
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

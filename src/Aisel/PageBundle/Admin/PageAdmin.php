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
        $this->pageManager = $pageManager ;
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
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('description' => 'This section contains general settings for the web page'))
                ->add('title', 'text', array('label' => 'Post Title','attr' => array('class' => 'span12')))
                ->add('content', 'ckeditor',
                    array(
                        'label' => 'Content',
                        'required' => true,
                        'attr' => array('class' => 'span10 field-content')
                ))
                ->add('status', 'choice', array('choices'   => array(
                        '0'   => 'Disabled',
                        '1' => 'Enabled'),
                        'label' => 'Status','attr' => array('class' => 'span3')
                    ))
                ->add('commentStatus', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Comments','attr' => array('class' => 'span3')
                ))
                ->add('isHidden', null, array('required' => false,'label' => 'Hidden page'))
                ->add('frontenduser',null, array('label' => 'Assigned Frontend User'))

            ->with('Categories', array('description' => 'Select related categories'))
                ->add('categories', 'gedmotree', array('expanded' => true,'multiple' => true,
                    'class' => 'Aisel\CategoryBundle\Entity\Category',
                ))
            ->with('Meta', array('description' => 'Meta description for search engines'))
                ->add('metaUrl', 'text', array('label' => 'Url','help'=>'note: URL value must be unique'))
                ->add('metaTitle', 'text', array('label' => 'Title'))
                ->add('metaDescription', 'textarea', array('label' => 'Description'))
                ->add('metaKeywords', 'textarea', array('label' => 'Keywords'))
            ->end();

    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('content')
        ;
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
//            ->add('categories')
            ->add('frontenduser', null, array('label' => 'Frontend User'))
            ->add('status', 'boolean', array('label' => 'Status','editable' => true))
            ->add('isHidden', 'boolean', array('label' => 'Hidden','editable' => true))
            ->add('updatedAt', 'datetime', array('label' => 'Date'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Information')
                ->add('content')
                ->add('updatedAt')
                ->add('status','boolean')
            ->with('Categories')
                ->add('categories','tree')
            ->with('Meta')
                ->add('metaUrl')
                ->add('metaTitle')
                ->add('metaDescription')
                ->add('metaKeywords')
            ->with('General')
                ->add('id')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle')  ;
    }
}

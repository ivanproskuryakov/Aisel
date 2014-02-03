<?php

namespace Projectx\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class PageAdmin extends Admin
{
    protected $baseRoutePattern = 'page';
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('description' => 'This section contains general settings for the web page'))
                ->add('title', 'text', array('label' => 'Post Title'))
                ->add('content', 'textarea', array('label' => 'Content'))
                ->add('pageStatus', 'choice', array('choices'   => array(
                        '0'   => 'Draft',
                        '1' => 'Published'),
                        'label' => 'Status'
                    ))
                ->add('commentStatus', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Comments'
                ))
                ->add('categories', 'y_tree', array('expanded' => true,'multiple' => true,
                    'class' => 'Projectx\CategoryBundle\Entity\Category',
                ))
            ->with('Meta', array('description' => 'Meta description for search engines'))
                ->add('metaUrl', 'text', array('label' => 'Url slug'))
                ->add('metaTitle', 'text', array('label' => 'Title'))
                ->add('metaDescription', 'textarea', array('label' => 'Description'))
                ->add('metaKeywords', 'textarea', array('label' => 'Keywords'))
            ->end();

    }

    public function getFormTheme() {
        return array('ProjectxAdminBundle:Form:form_admin_fields.html.twig');
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
        $page->setDateCreated(new \DateTime(date('Y-m-d H:i:s')));
        $page->setDateModified(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function preUpdate($page)
    {
        $page->setDateModified(new \DateTime(date('Y-m-d H:i:s')));
    }


    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('content', null, array('template' => 'ProjectxPageBundle:Admin:content.html.twig', 'label'=>'Content','true'=>false))
            ->add('pageStatus', 'boolean', array('label' => 'Status','editable' => true))
            ->add('commentStatus', 'boolean', array('label' => 'Comments','editable' => true))
            ->add('dateModified', 'datetime', array('label' => 'Date'))
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
                ->add('dateModified')
                ->add('pageStatus','boolean')
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

}
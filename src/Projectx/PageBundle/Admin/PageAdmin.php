<?php

namespace Projectx\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class PageAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('description' => 'This section contains general settings for the web page'))
                ->add('title', 'text', array('label' => 'Post Title'))
                ->add('content', 'textarea', array('label' => 'Content'))
//                ->add('page_status', 'choice', array( 'choices'   => array( 'morning'   => 'Morning',
//                        'afternoon' => 'Afternoon',
//                        'evening'   => 'Evening',
//                    ),array('label' => 'Status')))
                ->add('page_status', 'choice', array('choices'   => array(
                        '0'   => 'Draft',
                        '1' => 'Published'),
                        'label' => 'Status'
                    ))
                ->add('comment_status', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Comments'
                ))
            ->with('Meta', array('description' => 'Meta description for search engines'))
                ->add('meta_url', 'text', array('label' => 'Url slug'))
                ->add('meta_Title', 'text', array('label' => 'Title'))
                ->add('meta_description', 'textarea', array('label' => 'Description'))
                ->add('meta_keywords', 'textarea', array('label' => 'Keywords'))
            ->end();

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
            ->add('content')
            ->add('page_status', 'datetime', array('label' => 'Status'))
            ->add('comments_status', 'datetime', array('label' => 'Comments'))
            ->add('date_modified', 'datetime', array('label' => 'Date'))

        ;
    }

}
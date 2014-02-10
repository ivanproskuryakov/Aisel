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


class PageAdmin extends Admin
{
    protected $baseRoutePattern = 'page';
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('description' => 'This section contains general settings for the web page'))
                ->add('title', 'text', array('label' => 'Post Title','attr' => array('class' => 'span12')))
                ->add('content', 'ckeditor',
                    array(
                        'label' => 'Content',
                        'attr' => array('class' => 'span10 field-content'),
                        'config' => array(
                            'styles' => 'my_styles',
                        ),
                        'styles' => array(
                            'my_styles' => array(
                                array('name' => 'Blue Title', 'element' => 'h2', 'styles' => array('color' => 'Blue')),
                                array('name' => 'CSS Style', 'element' => 'span', 'attributes' => array('class' => 'span10')),
                            ),
                        ),
                ))
                ->add('pageStatus', 'choice', array('choices'   => array(
                        '0'   => 'Draft',
                        '1' => 'Published'),
                        'label' => 'Status','attr' => array('class' => 'span3')
                    ))
                ->add('commentStatus', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Comments','attr' => array('class' => 'span3')
                ))

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

    public function getFormTheme() {
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
            ->add('content', null, array('template' => 'AiselPageBundle:Admin:content.html.twig', 'label'=>'Content','true'=>false))
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
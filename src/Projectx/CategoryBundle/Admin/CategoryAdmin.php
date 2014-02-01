<?php

namespace Projectx\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Form\FormMapper;


class CategoryAdmin extends Admin
{

    protected $maxPerPage = 500;
    protected $maxPageLinks = 500;

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->orderBy('o.root', 'ASC');
        $query->addOrderBy('o.lft', 'ASC');

        return $query;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $subject = $this->getSubject();
        $id = $subject->getId();
//        $id = 1;

        $formMapper
            ->with('General', array('description' => 'This section contains general settings'))
                ->add('title', 'text', array('label' => 'Title'))
                ->add('description', 'textarea', array('label' => 'Description'))
                ->add('parent', null, array('label' => 'Parent', 'required' => false, 'query_builder' => function ($er) use ($id) {
                        $qb = $er->createQueryBuilder('p');
                        if ($id) {
                            $qb ->where('p.id <> :id')->setParameter('id', $id);
                        }
                        $qb ->orderBy('p.root, p.lft', 'ASC');
                        return $qb;
                    }, 'empty_value' => 'Set as root'
                ))
                ->add('status', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Status'
                ))

            ->with('Meta', array('description' => 'Meta description for search engines'))
                ->add('meta_url', 'text', array('label' => 'Url'))
                ->add('meta_Title', 'text', array('label' => 'Title'))
                ->add('meta_description', 'textarea', array('label' => 'Description'))
                ->add('meta_keywords', 'textarea', array('label' => 'Keywords'))
            ->end();

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
            ->addIdentifier('id', null,array('sortable'=>false))
            ->add('status', 'boolean', array('label' => 'Enabled','editable' => true))
            ->add('title', null, array('template' => 'ProjectxCategoryBundle:Admin:title.html.twig', 'label'=>'Title','sortable'=>false))
            ->add('description', 'text', array('label' => 'Description'))
            ->add('order', 'text', array('template' => 'ProjectxCategoryBundle:Admin:order.html.twig', 'label'=>'Move'))

            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ))
            );
    }

}
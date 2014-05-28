<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Category CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CategoryAdmin extends Admin
{
    protected $categoryManager;
    protected $baseRoutePattern = 'category';
    protected $maxPerPage = 500;
    protected $maxPageLinks = 500;

    public function setManager($categoryManager)
    {
        $this->categoryManager = $categoryManager ;
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
            ->with('description')
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
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->orderBy('o.root', 'ASC');
        $query->addOrderBy('o.lft', 'ASC');

        return $query;
    }

    public function getFormTheme()
    {
        return array('AiselAdminBundle:Form:form_admin_fields.html.twig');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $subject = $this->getSubject();
        $id = $subject->getId();
//        $id = 1;

        $formMapper
            ->with('General', array('description' => 'This section contains general settings'))
                ->add('title', 'text', array('label' => 'Title','attr' => array('class' => 'span12')))
                ->add('description', 'ckeditor',
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
                ->add('status', 'choice', array('choices'   => array(
                    '0'   => 'Disabled',
                    '1' => 'Enabled'),
                    'label' => 'Status','attr' => array('class' => 'span3')
                ))
                ->add('parent', 'gedmotree', array('expanded' => true,'multiple' => false,
                    'class' => 'Aisel\CategoryBundle\Entity\Category',
                    'query_builder' => function ($er) use ($id) {
                        $qb = $er->createQueryBuilder('p');
                        if ($id) {
                            $qb ->where('p.id <> :id')->setParameter('id', $id);
                        }
                        $qb ->orderBy('p.root, p.lft', 'ASC');

                        return $qb;
                    }, 'empty_value' => 'no parent'

                ))

            ->with('Meta', array('description' => 'Meta description for search engines'))
                ->add('metaUrl', 'text', array('label' => 'Url','help'=>'note: URL value must be unique'))
                ->add('metaTitle', 'text', array('label' => 'Title'))
                ->add('metaDescription', 'textarea', array('label' => 'Description'))
                ->add('metaKeywords', 'textarea', array('label' => 'Keywords'))
            ->end();

    }

    public function prePersist($category)
    {
        $url = $category->getMetaUrl();
        $normalUrl = $this->categoryManager->normalizeCategoryUrl($url);

        $category->setMetaUrl($normalUrl);
        $category->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $category->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function preUpdate($category)
    {
        $url = $category->getMetaUrl();
        $categoryId = $category->getId();
        $normalUrl = $this->categoryManager->normalizeCategoryUrl($url, $categoryId);

        $category->setMetaUrl($normalUrl);
        $category->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null,array('sortable'=>false))
            ->add('status', 'boolean', array('label' => 'Enabled','editable' => true))
            ->add('title', null, array('template' => 'AiselCategoryBundle:Admin:title.html.twig', 'label'=>'Title','sortable'=>false))
            ->add('order', 'text', array('template' => 'AiselCategoryBundle:Admin:order.html.twig', 'label'=>'Move'))

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
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Information')
                ->add('updatedAt')
                ->add('status')
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

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

    /**
     * Set page manager for Sonata
     */
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
        $subject = $this->getSubject();
        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array(
                'class' => 'form-control'
            )))
            ->add('title', 'text', array('label' => 'aisel.default.title', 'attr' => array()))
            ->add('content', 'ckeditor',
                array(
                    'label' => 'aisel.default.content',
                    'required' => true,
                    'attr' => array('class' => 'field-content')
                ))
            ->add('locale', 'aisel_locale', array('label' => 'aisel.default.locale',
                'required' => true,
                'attr' => array('class' => 'form-control')))
            ->add('status', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.disabled'),
                '1' => $this->trans('aisel.default.enabled')),
                'required' => true,
                'label' => 'aisel.default.status',
                'attr' => array('class' => 'form-control')
            ))
            ->add('commentStatus', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.disabled'),
                '1' => $this->trans('aisel.default.enabled')),
                'label' => 'aisel.default.comments',
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('hidden', null, array('required' => false, 'label' => 'aisel.default.hidden_page'))
            ->end()
            // TODO: Display only locale filtered categories
            // TODO: Display categories as tree
            ->with('aisel.default.categories')
            ->add('categories', 'aisel_gedmotree', array(
                'expanded' => true,
                'multiple' => true,
                'class' => 'Aisel\PageBundle\Entity\Category',
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
            ->with('aisel.default.meta_data')
            ->add('metaUrl', 'text', array('label' => 'aisel.default.url',
                'required' => true,
                'help' => $this->trans('aisel.default.url_must_be_unique')))
            ->add('metaTitle', 'text', array('label' => 'aisel.default.meta_title',
                'required' => false))
            ->add('metaDescription', 'textarea', array(
                'label' => 'aisel.default.meta_description',
                'required' => false))
            ->add('metaKeywords', 'textarea', array(
                'label' => 'aisel.default.meta_keywords',
                'required' => false))
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
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'aisel.default.title'))
            ->add('content', null, array('label' => 'aisel.default.content'));
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
            ->addIdentifier('id', null, array('label' => 'aisel.default.id'))
            ->add('locale', 'text', array('label' => 'aisel.default.locale'))
            ->add('title', null, array('label' => 'aisel.default.title'))
            ->add('status', 'boolean', array('label' => 'aisel.default.status', 'editable' => false))
            ->add('updatedAt', 'datetime', array('label' => 'aisel.default.updated_at'))
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
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.information')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('locale', null, array('label' => 'aisel.default.locale'))
            ->add('content', null, array('label' => 'aisel.default.content'))
            ->add('status', 'boolean', array('label' => 'aisel.default.status'))
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
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'));

    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
}

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
 * Abstract Category CRUD class for Backend categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractCategoryAdmin extends Admin
{
    protected $categoryManager;
    protected $baseRoutePattern = 'category';
    protected $categoryEntity = 'Aisel\PageBundle\Entity\Category';

    /**
     * Set category manager for Sonata Admin
     */
    public function setManager($categoryManager)
    {
        $this->categoryManager = $categoryManager;
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
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->orderBy('o.root', 'ASC');
        $query->addOrderBy('o.lft', 'ASC');
        $query->addOrderBy('o.title', 'ASC');

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('title', 'text', array('label' => 'aisel.default.title'))
            ->add('locale', 'aisel_locale', array('label' => 'aisel.default.locale',
                'required' => false,
                'attr' => array('class' => 'form-control')))
            ->add('description', 'ckeditor',
                array(
                    'label' => 'aisel.default.description',
                    'required' => true,
                ))
            ->add('status', 'choice', array('choices' => array(
                '0' => $this->trans('aisel.default.disabled'),
                '1' => $this->trans('aisel.default.enabled')),
                'required' => false,
                'label' => 'aisel.default.status',
                'attr' => array('class' => 'form-control')
            ))
            ->end()
            ->with('aisel.default.categories')
            // TODO: Display only locale filtered categories
            // TODO: Display categories as tree
            ->add('parent', 'aisel_gedmotree', array(
                'expanded' => true,
                'multiple' => false,
                'class' => $this->categoryEntity,
                'label' => 'aisel.category.parent',
                'query_builder' => function ($er) use ($subject) {
                        $qb = $er->createQueryBuilder('c');
                        if ($subject->getLocale()) {
                            $qb->where('c.locale = :locale')->setParameter('locale', $subject->getLocale());
                        }
                        if ($subject->getId()) {
                            $qb->andWhere('c.id != :id')->setParameter('id', $subject->getId());
                        }

                        return $qb;
                    }, 'empty_value' => $this->trans('aisel.default.no_parent')
            ))
            ->end()
            ->with('aisel.default.meta_data')
            ->add('metaUrl', 'text', array('label' => 'aisel.default.url', 'required' => true,
                'help' => $this->trans('aisel.default.url_must_be_unique')))
            ->add('metaTitle', 'text', array('label' => 'aisel.default.meta_title', 'required' => false))
            ->add('metaDescription', 'textarea', array('label' => 'aisel.default.meta_description', 'required' => false))
            ->add('metaKeywords', 'textarea', array('label' => 'aisel.default.meta_keywords', 'required' => false))
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
    public function prePersist($category)
    {
        $url = $category->getMetaUrl();
        $normalUrl = $this->categoryManager->normalizeCategoryUrl($url);

        $category->setMetaUrl($normalUrl);
        $category->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $category->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($category)
    {
        $url = $category->getMetaUrl();
        $categoryId = $category->getId();
        $normalUrl = $this->categoryManager->normalizeCategoryUrl($url, $categoryId);

        $category->setMetaUrl($normalUrl);
        $category->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null,
                array('label' => 'Title', 'sortable' => false));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.information')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('title', 'text', array('label' => 'aisel.default.title'))
            ->add('locale', 'text', array('label' => 'aisel.default.locale'))
            ->add('status', 'boolean', array('label' => 'aisel.default.status'))
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

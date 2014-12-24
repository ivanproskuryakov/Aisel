<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Navigation CRUD configuration for Backend
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NavigationAdmin extends Admin
{
    protected $baseRoutePattern = 'navigation/menu';
    protected $maxPerPage = 500;
    protected $maxPageLinks = 500;

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('title')
            ->assertNotBlank()
            ->end()
            ->with('metaUrl')
            ->assertNotBlank()
            ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $subject = $this->getSubject();
        $id = $subject->getId();

        $formMapper
            ->with('aisel.default.general')
            ->add('id', 'text', array('label' => 'aisel.default.id', 'disabled' => true, 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('title', 'text', array('label' => 'aisel.default.title', 'attr' => array()))
            ->add('metaUrl', 'text', array('label' => 'aisel.default.url', 'required' => true))
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
            ->end()
            ->with('aisel.navigation.menu')
            ->add('parent', 'aisel_gedmotree', array('expanded' => true, 'multiple' => false,
                'class' => 'Aisel\NavigationBundle\Entity\Menu',
                'label' => 'aisel.category.parent',
                'query_builder' => function ($er) use ($subject) {
                        $qb = $er->createQueryBuilder('c');
                        if ($subject->getLocale()) {
                            $qb->where('c.locale = :locale')->setParameter('locale', $subject->getLocale());
                        }

                        return $qb;
                    }, 'empty_value' => $this->trans('aisel.default.no_parent')
            ))
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
    public function prePersist($page)
    {
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($page)
    {
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('aisel.default.information')
            ->add('id', null, array('label' => 'aisel.default.id'))
            ->add('locale', null, array('label' => 'aisel.default.locale'))
            ->add('metaUrl', null, array('label' => 'aisel.default.url'))
            ->add('status', 'boolean', array('label' => 'aisel.default.id'))
            ->end()
            ->with('aisel.default.dates')
            ->add('createdAt', null, array('label' => 'aisel.default.created_at'))
            ->add('updatedAt', null, array('label' => 'aisel.default.updated_at'));
    }

    /**
     * {@inheritDoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }

}

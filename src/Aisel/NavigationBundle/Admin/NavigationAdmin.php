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
        $id = $subject->getId();

        $formMapper
            ->with('General')
            ->add('title', 'text', array('label' => 'Title'))
            ->add('metaUrl', 'text', array('label' => 'URL'))
            ->add('status', 'choice', array('choices' => array(
                '0' => 'Disabled',
                '1' => 'Enabled'),
                'label' => 'Status'
            ))
            ->add('parent', 'aisel_gedmotree', array('expanded' => true, 'multiple' => false,
                'class' => 'Aisel\NavigationBundle\Entity\Menu',
                'query_builder' => function ($er) use ($id) {
                        $qb = $er->createQueryBuilder('p');
                        if ($id) {
                            $qb->where('p.id <> :id')->setParameter('id', $id);
                        }
                        $qb->orderBy('p.root, p.lft', 'ASC');

                        return $qb;
                    }, 'empty_value' => 'no parent'

            ))
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
            ->with('Information')
            ->add('id')
            ->add('title')
            ->add('metaUrl')
            ->add('status')
            ->with('Dates')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * {@inheritDoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getTitle() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }

}

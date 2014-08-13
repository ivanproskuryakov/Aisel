<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AddressingBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * Backend country CRUD
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class CountryAdmin extends Admin
{
    protected $baseRoutePattern = 'address/country';
    protected $encoderFactory;

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('id')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('iso2', 'text', array('required' => true))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('iso2');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('iso2')

            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ))
            );
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($user)
    {
        $encoder = $this->getEncoderFactory()->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
        $user->setPassword($encodedPassword);

        $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        if ($user->getPlainPassword()) {
            $encoder = $this->getEncoderFactory()->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($encodedPassword);
        }

        $user->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    public function getEncoderFactory()
    {
        return $this->encoderFactory;
    }

    public function setEncoderFactory($encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getId() ? $object->getUsername() : $this->trans('link_add', array(), 'SonataAdminBundle');
    }

}

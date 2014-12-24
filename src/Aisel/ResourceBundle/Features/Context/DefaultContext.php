<?php

namespace Aisel\ResourceBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

abstract class DefaultContext extends RawMinkContext implements Context, KernelAwareContext
{

    /**
     * Actions.
     *
     * @var array
     */
    protected $actions = array(
        'viewing' => 'show',
        'creation' => 'create',
        'editing' => 'update',
        'building' => 'build',
    );

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Find one resource by name.
     *
     * @param string $type
     * @param string $name
     *
     * @return object
     */
    protected function findOneByName($type, $name)
    {
        return $this->findOneBy($type, array('name' => trim($name)));
    }

    /**
     * Find one resource by criteria.
     *
     * @param string $type
     * @param array  $criteria
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    protected function findOneBy($type, array $criteria)
    {
        $resource = $this
            ->getRepository($type)
            ->findOneBy($criteria);

        if (null === $resource) {
            throw new \InvalidArgumentException(
                sprintf('%s for criteria "%s" was not found.', str_replace('_', ' ', ucfirst($type)), serialize($criteria))
            );
        }

        return $resource;
    }

    /**
     * Get entity manager.
     *
     * @return ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->getService('doctrine')->getManager();
    }

    /**
     * Returns Container instance.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Get service by id.
     *
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Get current user instance.
     *
     * @return null|UserInterface
     *
     * @throws \Exception
     */
    protected function getUser()
    {
        $token = $this->getSecurityContext()->getToken();

        if (null === $token) {
            throw new \Exception('No token found in security context.');
        }

        return $token->getUser();
    }

    /**
     * Get security context.
     *
     * @return SecurityContextInterface
     */
    protected function getSecurityContext()
    {
        return $this->getContainer()->get('security.context');
    }

    /**
     * Generate url.
     *
     * @param string  $route
     * @param array   $parameters
     * @param Boolean $absolute
     *
     * @return string
     */
    protected function generateUrl($route, array $parameters = array(), $absolute = false)
    {
        return $this->getService('router')->generate($route, $parameters, $absolute);
    }

    /**
     * Presses button with specified id|name|title|alt|value.
     */
    protected function pressButton($button)
    {
        $this->getSession()->getPage()->pressButton($button);
    }

    /**
     * Fills in form field with specified id|name|label|value.
     */
    protected function fillField($field, $value)
    {
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * Find element by name
     *
     * @param string $value
     *
     * @return \Behat\Mink\Element\NodeElement
     */
    protected function findByName($value)
    {
        return $this->getSession()->getPage()->findField($value);
    }

    /**
     * Find element by css class name
     *
     * @param string $value
     *
     * @return \Behat\Mink\Element\NodeElement
     */
    protected function findByCSS($value)
    {
        return $this->getSession()->getPage()->find('css', $value);
    }

    /**
     * Login as backend user
     */
    protected function doBackendLogin()
    {
        $this->getSession()->visit($this->generateUrl('admin_login', array('_locale' => 'en')));
        $this->fillField('_username', 'backenduser');
        $this->fillField('_password', 'backenduser');
        $this->pressButton('_submit');
    }

}

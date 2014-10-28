<?php

namespace Aisel\ResourceBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

abstract class SonataAdminContext extends DefaultContext
{

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

    /**
     * Tree of entities
     */
    public function showTree()
    {
        $element = $this->findByCSS('.fancytree-container');
        return $element;
    }

    /**
     * List of entities
     */
    public function showList()
    {
        $element = $this->findByCSS('.sonata-link-identifier');
        return $element;
    }

    /**
     * Click on Edit button and return element
     */
    public function editButtonClick()
    {
        $element = $this->findByCSS('.edit_link');
        $element->click();
        $this->assertSession()->statusCodeEquals(200);
        $element = $this->findByCSS('.sonata-ba-collapsed-fields');
        return $element;
    }

    /**
     * Click on Show button and return element
     */
    public function showButtonClick()
    {
        $element = $this->findByCSS('.view_link');
        $element->click();
        $this->assertSession()->statusCodeEquals(200);
        $element = $this->findByCSS('.sonata-ba-show');
        return $element;
    }

    /**
     * Click on Delete button and return element
     */
    public function deleteButtonClick()
    {
        $element = $this->findByCSS('.delete_link');
        $element->click();
        $this->assertSession()->statusCodeEquals(200);
        $element = $this->findByCSS('.btn-danger');
        return $element;
    }

}

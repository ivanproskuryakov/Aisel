<?php

namespace Aisel\ResourceBundle\Features\Context;

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
     * Click on Edit button and return the element
     */
    public function addButtonClick()
    {
        $element = $this->findByCSS('.sonata-action-element');
        $element->click();
        $this->assertSession()->statusCodeEquals(200);
        $element = $this->findByCSS('.sonata-ba-collapsed-fields');

        return $element;
    }
    /**
     * Click on Edit button and return the element
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
     * Click on Show button and return the element
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
     * Click on Delete button and return the element
     */
    public function deleteButtonClick()
    {
        $element = $this->findByCSS('.delete_link');
        $element->click();
        $this->assertSession()->statusCodeEquals(200);
        $element = $this->findByCSS('.btn-danger');

        return $element;
    }

    // ---------

    /**
     * @Given /^I press "Create and return to list" button$/
     */
    public function iPressCreateAndReturnToListButton()
    {
        $this->pressButton('btn_create_and_edit');
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^New entity with "([^"]*)" = "([^"]*)" has to be displayed$/
     */
    public function newEntityDisplayed($field, $value)
    {
        $id = $this->findByCSS('.uniqid')->getText();
        $elementValue = $this->findByName($id . '[' . $field . ']')->getValue();
        assertEquals($elementValue, $value);
    }

    /**
     * @Given /^I enter "([^"]*)" in "([^"]*)"$/
     * @Given /^I select "([^"]*)" in "([^"]*)"$/
     */
    public function iEnterValueForField($value, $field)
    {
        $id = $this->findByCSS('.uniqid')->getText();
        $this->fillField($id . '_' . $field, $value);
    }

    /**
     * @Given /^I click on "Add new" link$/
     */
    public function iClickOnAddNewLink()
    {
        $element = $this->addButtonClick();
        assertNotEmpty($element->getText());
    }

}

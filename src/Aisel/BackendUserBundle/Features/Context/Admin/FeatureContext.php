<?php

namespace Aisel\BackendUserBundle\Features\Context\Admin;

use Aisel\ResourceBundle\Features\Context\SonataAdminContext;

/**
 * Behat CRUD for backend user entities
 */
class FeatureContext extends SonataAdminContext
{

    /**
     * @When /^I'm logged in as backend user$/
     */
    public function IamBackendUser()
    {
        $this->doBackendLogin();
    }

    /**
     * @When /^I visit backend user list route admin_aisel_backenduser_backenduser_list$/
     */
    public function browseToBEUserListRoute()
    {
        $this->getSession()->visit($this->generateUrl('admin_aisel_backenduser_backenduser_list', array('_locale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^I should see list of rows$/
     */
    public function iSeeListOfRows()
    {
        $element = $this->showList();
        assertNotEmpty($element->getText());
    }

    /**
     * @Given /^I click on "Show" button and see details$/
     */
    public function iSeeEntityDetails()
    {
        $element = $this->showButtonClick();
        assertNotEmpty($element->getText());
    }

    /**
     * @Given /^I click on "Edit" button and see edit form$/
     */
    public function iSeeEditForm()
    {
        $element = $this->editButtonClick();
        assertNotEmpty($element->getText());
    }

    /**
     * @Given /^I click on "Delete" button and see confirmation$/
     */
    public function iSeeConfirmationMessage()
    {
        $element = $this->deleteButtonClick();
        assertNotEmpty($element->getText());
    }

}

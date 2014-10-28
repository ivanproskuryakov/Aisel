<?php

namespace Aisel\NavigationBundle\Features\Context\Admin;

use Aisel\ResourceBundle\Features\Context\SonataAdminContext;

/**
 * Behat CRUD for navigation menu
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
     * @When /^I visit navigation menu tree route admin_aisel_navigation_menu_list$/
     */
    public function browseToMenuListRoute()
    {
        $this->getSession()->visit($this->generateUrl('admin_aisel_navigation_menu_list', array('_locale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^I should see rows displayed as a tree$/
     */
    public function iSeeNavigationTree()
    {
        $element = $this->showTree();
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

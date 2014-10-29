<?php

namespace Aisel\ContactBundle\Features\Context\Admin;

use Aisel\ResourceBundle\Features\Context\SonataAdminContext;

/**
 * Behat contact settings
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
     * @When /^I visit contact settings route config_contact$/
     */
    public function browseToContactSettingsRoute()
    {
        $this->getSession()->visit($this->generateUrl('config_contact', array('_locale' => 'en', 'editLocale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^I should see contact settings form$/
     */
    public function iSeeContactSettingsForm()
    {
        $element = $this->findByCSS('.aisel_config_settings_modify');
        assertNotEmpty($element->getText());
    }

}

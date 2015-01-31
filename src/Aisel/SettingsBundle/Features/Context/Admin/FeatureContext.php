<?php

namespace Aisel\SettingsBundle\Features\Context\Admin;

use Aisel\ResourceBundle\Features\Context\SonataAdminContext;

/**
 * Behat admin settings
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
     * @When /^I visit content settings route config_content$/
     */
    public function browseToHomepageSettingsRoute()
    {
        $this->getSession()->visit($this->generateUrl('config_content', array('_locale' => 'en', 'editLocale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @When /^I visit disqus settings route config_disqus$/
     */
    public function browseToDisqusSettingsRoute()
    {
        $this->getSession()->visit($this->generateUrl('config_disqus', array('_locale' => 'en', 'editLocale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }
    /**
     * @When /^I visit META settings route config_meta$/
     */
    public function browseToMETASettingsRoute()
    {
        $this->getSession()->visit($this->generateUrl('config_meta', array('_locale' => 'en', 'editLocale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^I should see homepage settings form$/
     */
    public function iSeeHomepageSettingsForm()
    {
        $element = $this->findByCSS('.aisel_config_settings_modify');
        assertNotEmpty($element->getText());
    }

    /**
     * @Given /^I should see disqus settings form$/
     */
    public function iSeeDisqusSettingsForm()
    {
        $element = $this->findByCSS('.aisel_config_settings_modify');
        assertNotEmpty($element->getText());
    }
    /**
     * @Given /^I should see META settings form$/
     */
    public function iSeeMetaSettingsForm()
    {
        $element = $this->findByCSS('.aisel_config_settings_modify');
        assertNotEmpty($element->getText());
    }

}

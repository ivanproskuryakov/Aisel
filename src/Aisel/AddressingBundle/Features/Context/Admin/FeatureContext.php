<?php

namespace Aisel\AddressingBundle\Features\Context\Admin;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

/**
 * Behat context class.
 */
class FeatureContext extends DefaultContext
{

    /**
     * @When /^I'm logged in as backend user$/
     */
    public function weAreBackendUser()
    {
        $this->doBackendLogin();
    }

    /**
     * @When /^I visit city list route admin_aisel_addressing_city_list$/
     */
    public function scriptAccessRoute()
    {
        $this->getSession()->visit($this->generateUrl('admin_aisel_addressing_city_list', array('_locale' => 'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^I should see cities$/
     */
    public function pageWithCityList()
    {
        $el = $this->findByCSS('.sonata-ba-list');
        assertNotEmpty($el->getText());
    }

}

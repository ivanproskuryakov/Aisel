<?php

namespace Aisel\AddressingBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

/**
 * Behat context class.
 */
class FeatureContext extends DefaultContext
{

    /**
     * @When /^Script access api_aisel_addressing_city_list route$/
     */
    public function scriptAccessRoute()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_addressing_city_list'));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Content contains valid JSON$/
     */
    public function contentContainsValidJSON()
    {
        $content = $this->getSession()->getPage()->getContent();
        $json = json_decode($content);
        assertNotEmpty($json);
    }

}

<?php

namespace Aisel\CategoryBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

/**
 * Behat context class.
 */
class FeatureContext extends DefaultContext
{

    /**
     * @When /^Script access api_aisel_categorylist route$/
     */
    public function scriptAccessRoute()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_page_categorylist'));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Content contains valid JSON$/
     */
    public function contentContainsValidJSON()
    {
        $content = $this->getSession()->getPage()->getContent();
        $json = json_decode($content);
        assertNotEmpty($json->total);
    }

}

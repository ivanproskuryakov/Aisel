<?php

namespace Aisel\CategoryBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends DefaultContext
{

    /**
     * @When /^Script access api_aisel_categorylist route$/
     */
    public function goToCategoryListURI()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_categorylist'));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Content should contain valid JSON$/
     */
    public function jsonHasTotal()
    {
        $json = $this->getSession()->getPage()->getContent();
        $categoryDetails = json_decode($json);
        assertNotEmpty($categoryDetails->total);
    }

}

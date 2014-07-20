<?php

namespace Aisel\NavigationBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext extends DefaultContext
{

    /**
     * @When /^Script access api_aisel_navigationmenu route$/
     */
    public function scriptAccessRoute()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_navigationmenu'));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Content contains valid JSON$/
     */
    public function contentContainsValidJSON()
    {
        $content = $this->getSession()->getPage()->getContent();
        $json = json_decode($content);
        assertNotEmpty($json[0]->id);
    }

}

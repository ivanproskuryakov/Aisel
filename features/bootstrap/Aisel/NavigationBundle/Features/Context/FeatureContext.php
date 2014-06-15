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
    public function goToCategoryListURI()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_navigationmenu'));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Navigation response should contain valid JSON$/
     */
    public function navigationContentContainsJSON()
    {
        $json = $this->getSession()->getPage()->getContent();
        $menuDetails = json_decode($json);
//        var_dump($menuDetails[0]->id);
//        exit();
        assertNotEmpty($menuDetails[0]->id);
    }

}

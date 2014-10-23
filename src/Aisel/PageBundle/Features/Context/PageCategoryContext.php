<?php

namespace Aisel\PageBundle\Features\Context;

use Aisel\ResourceBundle\Features\Context\DefaultContext;

/**
 * Behat context class.
 */
class PageCategoryContext extends DefaultContext
{

    /**
     * @When /^Script access api_aisel_page_categorylist route$/
     */
    public function scriptAccessRoute()
    {
        $this->getSession()->visit($this->generateUrl('api_aisel_page_categorylist', array('locale'=>'en')));
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @Given /^Content contains valid Category JSON$/
     */
    public function contentContainsValidJSON()
    {
        $content = $this->getSession()->getPage()->getContent();
        $json = json_decode($content);
        assertNotEmpty($json->total);
    }

}

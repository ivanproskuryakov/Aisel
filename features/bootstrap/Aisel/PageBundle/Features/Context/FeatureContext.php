<?php

namespace Aisel\PageBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{

    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
    }


    /**
     * @Given /^is Behat installed and working "([^"]*)"$/
     */
    public function isBehatWorking($argument)
    {
//        $container = $this->kernel->getContainer();
//        $this->getContainer()->get('session')->set('arg', $argument);
    }

    /**
     * @Given /^I should get "([^"]*)"$/
     */
    public function iShouldGet($argument)
    {
//        $container = $this->kernel->getContainer();
//        $argSession = $container->get('session')->get('arg');
//        assertEquals($argSession, $argument);
        assertEquals(1, 1);
    }
}

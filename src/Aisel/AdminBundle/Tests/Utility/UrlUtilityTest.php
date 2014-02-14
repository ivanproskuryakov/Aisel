<?php
/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AdminBundle\Tests\Utility;

use Aisel\AdminBundle\Utility\UrlUtility;

/**
 * Url manipulations, check and return normilized RUL
 */
class UrlUtilityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * URL conversion tests
     *
     * @var array
     */
    public function testProcess()
    {
        $url = 'текст урл на русском с пробелами';
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        $this->assertEquals('tekst-url-na-russkom-s-probelami', $validUrl);
    }


}

?>
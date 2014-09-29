<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Tests\Utility;

use Aisel\ResourceBundle\Utility\UrlUtility;
use Aisel\ResourceBundle\PHPUnit\BaseTestCase;

/**
 * Url manipulations test case
 */
class UrlUtilityTest extends BaseTestCase
{

    /**
     * URL conversion tests
     *
     * @return null
     */
    public function testProcess()
    {
        $url = 'текст урл на русском с пробелами';
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        $this->assertEquals('tekst-url-na-russkom-s-probelami', $validUrl);
    }

}

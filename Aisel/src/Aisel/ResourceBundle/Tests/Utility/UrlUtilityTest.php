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

use Aisel\ResourceBundle\Tests\AbstractKernelTestCase;
use Aisel\ResourceBundle\Utility\UrlUtility;

/**
 * UrlUtilityTest
 */
class UrlUtilityTest extends AbstractKernelTestCase
{

    /**
     * testUrlUtiliry
     */
    public function testUrlUtiliry()
    {
        $url = 'текст урл на русском с пробелами';
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        $this->assertEquals('tekst-url-na-russkom-s-probelami', $validUrl);
    }

}

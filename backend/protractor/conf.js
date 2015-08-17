'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Aisel
 * @description     Protractor tests
 */

exports.config = {
    seleniumAddress: 'http://localhost:4444/wd/hub',
    specs: [
        'modules/auth.js',
        'modules/dashboard.js',
        'modules/addressing.js',
        'modules/backendUser.js',
        'modules/frontendUser.js',
        'modules/orders.js',
        'modules/products.js',
        'modules/page.js',
        'modules/navigation.js',
    ],

    // ----- Capabilities to be passed to the webdriver instance.
    // For a full list of available capabilities, see
    // https://code.google.com/p/selenium/wiki/DesiredCapabilities
    // and
    // https://code.google.com/p/selenium/source/browse/javascript/webdriver/capabilities.js
    capabilities: {
        //'browserName': 'firefox'
        'browserName': 'chrome'
            //'chromeOptions': { args: ['--test-type', 'show-fps-counter=true'] }
    }

};

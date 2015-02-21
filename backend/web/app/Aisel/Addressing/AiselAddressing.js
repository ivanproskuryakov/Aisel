'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Addressing
 * @description     Addressing module
 */

define(['app',
    './config/addressing',
    './controllers/country',
    './controllers/region',
    './controllers/city',
    './services/country',
    './services/region',
    './services/city',
], function (app) {
    console.log('Addressing module loaded ...');
});
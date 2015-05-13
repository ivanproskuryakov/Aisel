'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselResource
 * @description     Kernel module, module contains data that we cant decompose into module
 */

define(['app',
    './config/resource',
    './controllers/abstractDetails',
    './services/init',
    './services/collection',
    './services/resource',
    './directives/fancyTree',
], function (app) {
    console.log('----------- Kernel Loaded! -----------');
});


'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselBackendUser
 * @description     BackendUser module
 */

define(['app',
    './config/backendUser',
    './controllers/backendUser',
    './controllers/backendUserDetails',
    './services/backendUser',
], function (app) {
    console.log('BackendUser module loaded ...');
});
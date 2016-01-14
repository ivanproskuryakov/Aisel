'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAuth
 * @description     Auth module
 */

define(['app',
    './config/auth',
    './controllers/auth',
    './services/auth',
], function(app) {
    console.log('Auth module loaded ...');
});

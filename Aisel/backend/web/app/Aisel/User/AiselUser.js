'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselUser
 * @description     User module
 */

define(['app',
    './config/user',
    './controllers/user',
    './controllers/userDetails',
], function(app) {
    console.log('User module loaded ...');
});

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
 * @description     testing angularjs filters
 */

define(['app'], function (app) {
    app.filter('text', function () {
            return function (text, name) {
                return text;
            };
        }
    );
});
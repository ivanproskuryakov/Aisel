'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselNavigation
 * @description     ...
 */

define(['app'], function (app) {
    app.service('navigationService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                get: function ($id) {
                    var url = Environment.settings.api + '/navigation/' + $id;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
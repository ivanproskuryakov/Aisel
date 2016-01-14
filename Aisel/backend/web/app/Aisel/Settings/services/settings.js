'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSettings
 * @description     settingsService
 */

define(['app'], function(app) {
    app.service('settingsService', ['$http', 'Env',
        function($http, Env) {
            return {
                get: function() {
                    var url = Env.api + '/config/';
                    console.log(url);

                    return $http.get(url);
                },
                save: function(data) {
                    var url = Env.api + '/config/';

                    return $http({
                        method: 'PUT',
                        url: url,
                        data: data
                    });
                }
            };
        }
    ]);
});

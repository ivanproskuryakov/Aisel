'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselMedia
 * @description     mediaService
 */

define(['app'], function(app) {
    app.service('mediaService', ['$http', 'Environment',
        function($http, Environment) {

            return {
                new: function (data) {
                    var url = Environment.settings.api + '/media/';

                    return $http({
                        method: 'POST',
                        url: url,
                        data: data
                    });
                },
                delete: function (id) {
                    var url = Environment.settings.api + '/media/' + id;

                    return $http({
                        method: 'DELETE',
                        url: url
                    });
                }
            };
        }
    ]);
});

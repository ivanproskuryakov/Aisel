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
 * @description     ...
 */

define(['app'], function (app) {
    app.service('backendUserService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getCollection: function ($scope, pageNumber) {
                    var url = Environment.settings.api
                        + '/backenduser/?limit=' + $scope.pageLimit
                        + '&current=' + pageNumber
                        + '&filter=' + $scope.filter;

                    console.log(url);
                    return $http.get(url);
                },
                get: function ($id) {
                    var url = Environment.settings.api + '/backenduser/' + $id;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
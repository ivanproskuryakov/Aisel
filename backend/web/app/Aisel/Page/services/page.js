'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     pageService
 */

define(['app'], function (app) {
    app.service('pageService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getCollection: function ($scope, pageNumber) {
                    var url = Environment.settings.api
                        + '/page/?limit=' + $scope.pageLimit
                        + '&current=' + pageNumber
                        + '&filter=' + $scope.filter;

                    console.log(url);
                    return $http.get(url);
                },
                get: function ($id) {
                    var url = Environment.settings.api + '/page/' + $id;
                    console.log(url);
                    return $http.get(url);
                },
                remove: function ($id) {
                    var url = Environment.settings.api + '/page/' + $id;
                    console.log(url);
                    return $http.delete(url);
                },
                save: function (data) {
                    var url = Environment.settings.api + '/page/' + data.id;
                    return $http({
                        method: 'PUT',
                        url: url,
                        data: data
                    });
                },
                create: function (data) {
                    var url = Environment.settings.api + '/page/';
                    return $http({
                        method: 'POST',
                        url: url,
                        data: data
                    });
                },
                getCategory: function ($id) {
                    var url = Environment.settings.api + '/page/category/' + $id;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
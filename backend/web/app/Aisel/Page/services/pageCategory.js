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
 * @description     ...
 */

define(['app'], function (app) {
    app.service('pageCategoryService', ['$http', 'Environment',
        function ($http, Environment) {
            return {
                getCategories: function ($scope) {
                    var url = Environment.settings.api + '/page/category/?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                },
                getCategory: function (categoryId) {
                    var url = Environment.settings.api + '/page/category/' + categoryId;
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
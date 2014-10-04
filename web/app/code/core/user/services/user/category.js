'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

angular.module('aiselApp')
    .service('userCategoryService', ['$http', '$routeParams', 'API_URL', function ($http, $routeParams, API_URL) {
        return {

            appCategories: function () {

                var url = API_URL + '/user/category/tree.json';
                console.log(url);
                return $http.get(url);
            }
        };

    }]);

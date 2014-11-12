'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('categoryService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getCategories: function ($scope) {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/product/category/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                },
                getCategory: function (categoryId) {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/product/category/view/' + categoryId + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('productService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getProducts: function ($scope) {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/product/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage + '&category=' + $scope.categoryId;
                    console.log(url);
                    return $http.get(url);
                },
                getProductByURL: function ($url) {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/product/view/url/' + $url + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
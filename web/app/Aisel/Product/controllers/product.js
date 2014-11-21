'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('ProductCtrl', ['$location', '$scope', '$routeParams', 'productService', '$rootScope',
        function ($location, $scope, $routeParams, productService, $rootScope) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            var handleSuccess = function (data, status) {
                $scope.productList = data;
            };

            // Product
            productService.getProducts($scope).success(
                function (data, status) {
                    $scope.productList = data;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                productService.getProducts($scope).success(
                    function (data, status) {
                        $scope.productList = data;
                    }
                );
            };

        }]);
});
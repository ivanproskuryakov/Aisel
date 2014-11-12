'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('CategoryDetailCtrl', ['$location', '$scope', '$routeParams', 'productService', 'categoryService',
        function ($location, $scope, $routeParams, productService, categoryService) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = $routeParams.categoryId;

            // Category Information
            categoryService.getCategory($scope.categoryId).success(
                function (data, status) {
                    $scope.categoryDetails = data;
                }
            );

            // Pages
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
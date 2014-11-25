'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('ProductCategoryCtrl', ['$location', '$scope', '$routeParams', 'productCategoryService',
        function ($location, $scope, $routeParams, productCategoryService) {
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                productCategoryService.getCategories($scope).success(
                    function (data, status) {
                        $scope.productCategoryList = data;
                    }
                );
            };

            // Categories
            productCategoryService.getCategories($scope).success(
                function (data, status) {
                    $scope.productCategoryList = data;
                }
            );
        }]);
});
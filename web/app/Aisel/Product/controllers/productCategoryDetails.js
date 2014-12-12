'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @ngdoc           overview
 * @name            Aisel
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductCategoryDetailCtrl', ['$location', '$scope', '$routeParams', 'productService', 'productCategoryService',
        function ($location, $scope, $routeParams, productService, productCategoryService) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = $routeParams.categoryId;

            // Category Information
            productCategoryService.getCategory($scope.categoryId).success(
                function (data, status) {
                    $scope.categoryDetails = data;
                }
            );

            // Products
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
'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductCtrl', ['$location', '$scope', '$stateParams', 'productService', 'Environment',
        function ($location, $scope, $stateParams, productService, Environment) {
            $scope.media = Environment.settings.media;
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            var handleSuccess = function (data, status) {
                $scope.collection = data;
            };

            // Product
            productService.getProducts($scope).success(
                function (data, status) {
                    console.log(data);
                    $scope.collection = data;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                productService.getProducts($scope).success(
                    function (data, status) {
                        $scope.collection = data;
                    }
                );
            };

        }]);
});
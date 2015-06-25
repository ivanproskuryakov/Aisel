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
    app.controller('ProductCtrl', ['$scope', '$stateParams', 'productService', 'Environment',
        function ($scope, $stateParams, productService, Environment) {
            $scope.media = Environment.settings.media;
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            /**
             * Load product collection
             *
             * @param limit
             * @param page
             * @param categoryId
             * @param order
             * @param orderBy
             */
            var getProductCollection = function (limit, page, categoryId, order, orderBy) {
                var params = {
                    limit: limit,
                    page: page,
                    categoryId: categoryId,
                    order: order,
                    orderBy: orderBy
                };

                productService.getProducts(params).success(
                    function (data, status) {
                        console.log(data);
                        $scope.collection = data;
                    }
                );
            };

            getProductCollection(
                $scope.pageLimit,
                $scope.paginationPage,
                $scope.categoryId,
                'id',
                'ASC'
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;

                getProductCollection(
                    $scope.pageLimit,
                    $scope.paginationPage,
                    $scope.categoryId
                );
            };

        }]);
});
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

define(['app'], function(app) {
    app.controller('ProductCategoryDetailCtrl', ['$location', '$scope', '$stateParams', 'productService', 'productCategoryService', 'Environment',
        function($location, $scope, $stateParams, productService, productCategoryService, Environment) {
            $scope.media = Environment.settings.media;
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = $stateParams.categoryId;

            // Category Information
            productCategoryService.getCategory($scope.categoryId).success(
                function(data, status) {
                    $scope.category = data;
                }
            );


            /**
             * Load product collection
             *
             * @param limit
             * @param page
             * @param categoryId
             * @param order
             * @param orderBy
             */
            var getProductCollection = function(limit, page, categoryId, order, orderBy) {
                var params = {
                    limit: limit,
                    page: page,
                    categoryId: categoryId,
                    order: order,
                    orderBy: orderBy
                };
                productService.getProducts(params).success(
                    function(data, status) {
                        $scope.productList = data;
                    }
                );
            };

            // Products
            getProductCollection(
                $scope.pageLimit,
                $scope.paginationPage,
                $scope.categoryId,
                'id',
                'ASC'
            );

            $scope.pageChanged = function(paginationPage) {
                getProductCollection(
                    $scope.pageLimit,
                    paginationPage,
                    $scope.categoryId,
                    'id',
                    'ASC'
                );
            };


        }
    ]);
});

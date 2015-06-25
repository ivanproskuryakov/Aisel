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
    app.directive('aiselNewProducts', ['$compile', 'productService', function($compile, productService){
        return {
            restrict: 'EA',
            //scope: {
            //    count: '@'
            //},
            link: function ($scope, element, attrs) {
                var productLimit = attrs.limit;

                // Product
                $scope.pageLimit = 5;
                $scope.paginationPage = 1;
                $scope.categoryId = 0;

                var params = {
                    limit: productLimit,
                    order: 'id',
                    orderBy: 'DESC',
                    page: 1
                };
                productService.getProducts(params).success(
                    function (data, status) {
                        $scope.newProducts = data;
                        $scope.newProducts.limit = productLimit;
                    }
                );

            },
            templateUrl: '/app/Aisel/Product/views/directives/new-products.html'
        };
    }]);
});
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
    app.directive(
        'aiselNewProducts', ['$compile', 'resourceService',
            function ($compile, resourceService) {
                return {
                    restrict: 'EA',
                    link: function ($scope, element, attrs) {
                        var productLimit = attrs.limit;
                        var params = {
                            limit: productLimit,
                            order: 'id',
                            orderBy: 'DESC',
                            page: 1
                        };
                        var productService = new resourceService('product');

                        productService.getCollection(params).success(
                            function (data, status) {
                                $scope.newProducts = data;
                                $scope.newProducts.limit = productLimit;
                            }
                        );

                    },
                    templateUrl: '/app/Aisel/Product/views/directives/new-products.html'
                };
            }
        ]);
});

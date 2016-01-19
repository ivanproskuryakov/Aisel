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
 * @description     Product config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("products", {
                url: "/:locale/products/",
                templateUrl: '/app/Aisel/Product/views/product.html',
                controller: 'ProductCtrl'
            })
            .state("productView", {
                url: "/:locale/product/view/:productId/",
                templateUrl: '/app/Aisel/Product/views/product-detail.html',
                controller: 'ProductDetailCtrl'
            })
            .state("productCategories", {
                url: "/:locale/product/categories/",
                templateUrl: '/app/Aisel/Product/views/category.html',
                controller: 'ProductCategoryCtrl'
            })
            .state("productCategoryView", {
                url: "/:locale/product/category/:categoryId/",
                templateUrl: '/app/Aisel/Product/views/category-detail.html',
                controller: 'ProductCategoryDetailCtrl'
            });
    }]);

    app.run(['$http', '$rootScope', 'productCategoryService',
        function ($http, $rootScope, productCategoryService) {
            
            // Load page categories
            productCategoryService.getProductCategoryTree().success(
                function (data, status) {
                    $rootScope.productCategoryTree = data;
                }
            );
        }
    ]);
});

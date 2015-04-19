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
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("products", {
                    url: "/:locale/products/",
                    templateUrl: '/app/Kernel/Resource/views/collection.html',
                    controller: 'ProductCtrl'
                })
                .state("productEdit", {
                    url: "/:locale/product/edit/:id/",
                    templateUrl: '/app/Aisel/Product/views/edit.html',
                    controller: 'ProductDetailsCtrl'
                })
                .state("productNew", {
                    url: "/:locale/product/new/",
                    templateUrl: '/app/Aisel/Product/views/edit.html',
                    controller: 'ProductDetailsCtrl'
                })
                .state("productCategory", {
                    url: "/:locale/product/category/",
                    templateUrl: '/app/Kernel/Resource/views/category.html',
                    controller: 'ProductCategoryCtrl'
                })
                .state("productCategoryEdit", {
                    url: "/:locale/product/category/edit/:id/",
                    templateUrl: '/app/Aisel/Product/views/edit-category.html',
                    controller: 'ProductCategoryDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 200,
                    "title": 'Products',
                    "children": {
                        "products": {
                            "ordering": 100,
                            "slug": '/products/',
                            "title": 'Products'
                        },
                        "productCategory": {
                            "ordering": 200,
                            "slug": '/product/category/',
                            "title": 'Categories'
                        }
                    }
                }
            );
        }]);
});
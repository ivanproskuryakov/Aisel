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
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
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

                .state("productReviews", {
                    url: "/:locale/product/review/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'ProductReviewCtrl'
                })
                .state("productReviewEdit", {
                    url: "/:locale/product/review/edit/:id/",
                    templateUrl: '/app/Aisel/Product/views/edit-review.html',
                    controller: 'ProductReviewDetailsCtrl'
                })
                .state("productReviewNew", {
                    url: "/:locale/product/review/new/",
                    templateUrl: '/app/Aisel/Product/views/edit-review.html',
                    controller: 'ProductReviewDetailsCtrl'
                })


                .state("productNode", {
                    url: "/:locale/product/node/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'ProductNodeCtrl'
                })
                .state("productNodeEdit", {
                    url: "/:locale/product/node/edit/:id/",
                    templateUrl: '/app/Aisel/Product/views/edit-node.html',
                    controller: 'ProductNodeDetailsCtrl'
                })
                .state("productNodeNew", {
                    url: "/:locale/product/node/new/",
                    templateUrl: '/app/Aisel/Product/views/edit-node.html',
                    controller: 'ProductNodeDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Env', function ($rootScope, Env) {
            $rootScope.adminMenu.push({
                "ordering": 200,
                "title": 'Products',
                "children": {
                    "products": {
                        "ordering": 100,
                        "slug": '/products/',
                        "title": 'Products'
                    },
                    "productNode": {
                        "ordering": 200,
                        "slug": '/product/node/',
                        "title": 'Nodes'
                    },
                    "productReview": {
                        "ordering": 300,
                        "slug": '/product/review/',
                        "title": 'Reviews'
                    }
                }
            });

            $rootScope.sellerMenu.push({
                "ordering": 200,
                "title": 'Products',
                "children": {
                    "products": {
                        "ordering": 100,
                        "slug": '/products/',
                        "title": 'Products'
                    },
                    "productReview": {
                        "ordering": 300,
                        "slug": '/product/review/',
                        "title": 'Reviews'
                    }
                }
            });
        }]);
});

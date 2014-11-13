'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Product router
 */

define(['app',
    './controllers/product', './controllers/productdetails',
    './services/product',
    './controllers/category', './controllers/categorydetails',
    './services/productcategory',
], function (app) {
    console.log('Product module loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider

            // Products
            .when('/:locale/products/', {
                templateUrl: '/app/Aisel/Product/views/product.html',
                controller: 'ProductCtrl'
            })
            .when('/:locale/product/view/:productId/', {
                templateUrl: '/app/Aisel/Product/views/product-detail.html',
                controller: 'ProductDetailCtrl'
            })
            // Categories
            .when('/:locale/product/categories/', {
                templateUrl: '/app/Aisel/Product/views/category.html',
                controller: 'CategoryCtrl'
            })
            .when('/:locale/product/category/:categoryId/', {
                templateUrl: '/app/Aisel/Product/views/category-detail.html',
                controller: 'CategoryDetailCtrl'
            })

    });
});
'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Category router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Categories
        .when('/:locale/categories/', {
            templateUrl: 'app/views/core/category/category.html',
            controller: 'CategoryCtrl'
        })
        .when('/:locale/category/:categoryId/', {
            templateUrl: 'app/views/core/category/category-detail.html',
            controller: 'CategoryDetailCtrl'
        })

});

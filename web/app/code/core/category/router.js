'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Router update for Homepage Module
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Categories
        .when('/categories/', {
            templateUrl: 'app/views/core/category/category.html',
            controller: 'CategoryCtrl'
        })
        .when('/category/:categoryId/', {
            templateUrl: 'app/views/core/category/category-detail.html',
            controller: 'CategoryDetailCtrl'
        })

});

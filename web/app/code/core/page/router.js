'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Search router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
    $routeProvider

        // Pages
        .when('/:locale/pages/', {
            templateUrl: 'app/views/core/page/page.html',
            controller: 'PageCtrl'
        })
        .when('/:locale/page/view/:pageId/', {
            templateUrl: 'app/views/core/page/page-detail.html',
            controller: 'PageDetailCtrl'
        })
        // Categories
        .when('/:locale/page/categories/', {
            templateUrl: 'app/views/core/page/category.html',
            controller: 'CategoryCtrl'
        })
        .when('/:locale/page/category/:categoryId/', {
            templateUrl: 'app/views/core/page/category-detail.html',
            controller: 'CategoryDetailCtrl'
        })

});

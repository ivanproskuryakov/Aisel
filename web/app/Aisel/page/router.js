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
            templateUrl: 'app/Aisel/page/views/page.html',
            controller: 'PageCtrl'
        })
        .when('/:locale/page/view/:pageId/', {
            templateUrl: 'app/Aisel/page/views/page-detail.html',
            controller: 'PageDetailCtrl'
        })
        // Categories
        .when('/:locale/page/categories/', {
            templateUrl: 'app/Aisel/page/views/category.html',
            controller: 'CategoryCtrl'
        })
        .when('/:locale/page/category/:categoryId/', {
            templateUrl: 'app/Aisel/page/views/category-detail.html',
            controller: 'CategoryDetailCtrl'
        })

});

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

        // Pages
        .when('/pages/', {
            templateUrl: 'app/views/core/page/page.html',
            controller: 'PageCtrl'
        })
        .when('/page/:pageId/', {
            templateUrl: 'app/views/core/page/page-detail.html',
            controller: 'PageDetailCtrl'
        })
});

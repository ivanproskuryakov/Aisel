'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Search router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Pages
        .when('/:locale/pages/', {
            templateUrl: 'app/views/core/page/page.html',
            controller: 'PageCtrl'
        })
        .when('/:locale/page/:pageId/', {
            templateUrl: 'app/views/core/page/page-detail.html',
            controller: 'PageDetailCtrl'
        })
});

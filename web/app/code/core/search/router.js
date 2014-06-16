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
        // Search
        .when('/search/:query', {
            templateUrl: 'app/views/core/search/search.html',
            controller: 'SearchCtrl'
        })
});

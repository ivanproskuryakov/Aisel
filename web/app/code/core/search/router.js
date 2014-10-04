'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider
        // Search
        .when('/:locale/search/:query', {
            templateUrl: 'app/views/core/search/search.html',
            controller: 'SearchCtrl'
        })
});

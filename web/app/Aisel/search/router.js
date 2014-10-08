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
            templateUrl: 'app/Aisel/search/views/search.html',
            controller: 'SearchCtrl'
        })
});

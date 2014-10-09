'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app', './controllers/search', './services/search'], function (app) {
    console.log('Search Router Loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider
            // Search
            .when('/:locale/search/:query', {
                templateUrl: 'app/Aisel/search/views/search.html',
                controller: 'SearchCtrl'
            })
    });
});
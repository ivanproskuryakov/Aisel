'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app', './controllers/search', './services/search', './directives/main'], function (app) {
    console.log('Search module loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider
            // Search
            .when('/:locale/search/:query', {
                templateUrl: '/app/Aisel/Search/views/search.html',
                controller: 'SearchCtrl'
            })
    });
});
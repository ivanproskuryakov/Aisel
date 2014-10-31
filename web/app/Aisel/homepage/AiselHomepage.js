'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Router for Homepage
 */

define(['app','./controllers/homepage'], function (app) {
    console.log('Homepage module loaded ...');
    app.config(function ($provide, $routeProvider) {
        $routeProvider
            // Homepage
            .when('/:locale/', {
                templateUrl: '/app/Aisel/Homepage/views/homepage.html',
                controller: 'HomepageCtrl'
            })
    });
});
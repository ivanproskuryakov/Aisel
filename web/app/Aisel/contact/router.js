'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Router for contact
 *
 */

define(['app', './controllers/contact', './services/contact'], function (app) {
    console.log('Contact Router Loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider
            // Contact
            .when('/:locale/contact/', {
                templateUrl: 'app/Aisel/contact/views/contact.html',
                controller: 'ContactCtrl'
            })
    });
});
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

        // Contact
        .when('/contact/', {
            templateUrl: 'app/views/core/contact/contact.html',
            controller: 'ContactCtrl'
        })

});

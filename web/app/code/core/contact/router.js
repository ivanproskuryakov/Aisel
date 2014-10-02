'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 * @description
 * # aiselApp
 *
 * Contact module router
 */

aiselApp.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {

    $routeProvider

        // Contact
        .when('/:locale/contact/', {
            templateUrl: 'app/views/core/contact/contact.html',
            controller: 'ContactCtrl'
        })

});

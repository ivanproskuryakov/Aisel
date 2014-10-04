'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Router for Homepage
 */

aiselApp.config(function ($provide, $routeProvider) {

    $routeProvider

        // Homepage
        .when('/:locale/', {
            templateUrl: 'app/views/core/homepage/homepage.html',
            controller: 'HomepageCtrl'
        })

});

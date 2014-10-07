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
            templateUrl: 'app/Aisel/homepage/views/homepage.html',
            controller: 'HomepageCtrl'
        })

});

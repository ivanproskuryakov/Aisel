'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Main service used in app.js
 */
define(['app'], function (app) {
    console.log('Auth service loaded ...');
    angular.module('app')
        .service('authService', ['$http', '$routeParams', '$rootScope', 'API_URL', 'appSettings',
            function ($http, $routeParams, $rootScope, API_URL, appSettings) {
                return {

                    /**
                     * Simple helper functions for user ACL
                     * see more at user/router.js
                     */
                    grantAccessAuthenticated: function () {// ($rootScope, $location) {
                        console.log('grantAccessAuthenticated');
                        if (!$rootScope.isAuthenticated) {
                            $location.path("/" + $rootScope.locale + "/");
                        }
                        return false;
                    },
                    grantAccessGuest: function () {
                        console.log('grantAccessGuest');
                        if ($rootScope.isAuthenticated) {
                            $location.path("/" + $rootScope.locale + "/");
                        }
                        return false;
                    }
                }
            }]);
});
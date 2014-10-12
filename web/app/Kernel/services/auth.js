'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Main service used in app.js
 */
define(['app'], function (app) {
    console.log('Kernel auth service loaded ...');
    angular.module('app')
        .service('authService', ['$http', '$routeParams', '$rootScope', '$location', 'rootService',
            function ($http, $routeParams, $rootScope, $location, rootService) {
                return {
                    roleUser: function () {
                        if ($rootScope.isAuthenticated !== true) {
                            $location.path("/");
                        } else {
                            rootService.getUserInformation().success(
                                function (data, status) {
                                    console.log('userHasAccess');
                                    $rootScope.isAuthenticated = false;
                                    if (data.username) {
                                        $rootScope.isAuthenticated = true;
                                        $rootScope.user = data;
                                    } else {
                                        $location.path("/");
                                    }
                                }
                            );
                        }
                    },
                    roleGuest: function () {
                        if ($rootScope.isAuthenticated !== true) {
                            console.log('roleGuest ...');
                            $location.path("/");
                        }
                    }
                }
            }]);
});
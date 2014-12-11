'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Auth service
 */
define(['app'], function (app) {
    console.log('Kernel Auth service loaded ...');
    angular.module('app')
        .service('authService', ['$http', '$routeParams', '$rootScope', '$location', 'rootService',
            function ($http, $routeParams, $rootScope, $location, rootService) {
                var locale = Aisel.getLocale();

                return {
                    roleUser: function () {
                        rootService.getUserInformation().success(
                            function (data, status) {
                                console.log('userHasAccess');
                                $rootScope.isAuthenticated = false;
                                if (data.username) {
                                    $rootScope.isAuthenticated = true;
                                    $rootScope.user = data;
                                } else {
                                    $location.path("/" + locale + "/");
                                }
                            }
                        );
                    },
                    roleGuest: function () {
                        rootService.getUserInformation().success(
                            function (data, status) {
                                console.log('userIsGuest');
                                if (data.username) {
                                    $rootScope.isAuthenticated = true;
                                    $location.path("/" + locale + "/user/information/");
                                } else {
                                    $rootScope.isAuthenticated = false;
                                }
                            }
                        );
                    }
                }
            }]);
});
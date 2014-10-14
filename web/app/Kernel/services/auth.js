'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * Auth service
 */
define(['app'], function (app) {
    console.log('Kernel Auth service loaded ...');
    angular.module('app')
        .service('authService', ['$http', '$routeParams', '$rootScope', '$location', 'rootService',
            function ($http, $routeParams, $rootScope, $location, rootService) {
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
                                    $location.path("/");
                                }
                            }
                        );
                    },
                    roleGuest: function () {
                        console.log($rootScope.isAuthenticated);
                        if (typeof $rootScope.isAuthenticated != 'undefined') {
                            console.log('roleGuest ...');
                            $location.path("/");
                        }
                    }
                }
            }]);
});
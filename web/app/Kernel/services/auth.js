'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     Auth service
 */

define(['app'], function (app) {
    console.log('Kernel Auth service loaded ...');
    angular.module('app')
        .service('authService', ['$http', '$rootScope', '$location', 'rootService',
            function ($http, $rootScope, $location, rootService) {
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
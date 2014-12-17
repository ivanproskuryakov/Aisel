'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselUser
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('UserCtrl', ['$log', '$modal', '$scope', '$routeParams', 'userService', 'notify',
        function ($log, $modal, $scope, $routeParams, userService, notify) {
            var locale = Aisel.getLocale();

            $scope.loggedIn = false;

            // User Registration
            $scope.submitRegistration = function (form) {
                if (form.$valid) {
                    userService.register(form).success(
                        function (data, status) {
                            notify(data.message);
                            if (data.status) {
                                window.location = "/";
                            }
                        }
                    );
                }
            };

            /**
             * @ngdoc function
             * @param form registration form values
             * @description sends data to API layer and update user object
             */
            $scope.submitEditUserDetails = function (form) {
                if (form.$valid) {
                    userService.editDetails(form).success(
                        function (data, status) {
                            notify(data.message);
//                        if (data.status) {
//                            window.location = "/#/user/information/";
//                        }
                        }
                    );
                }
            };

            // User Password Forgot
            $scope.submitPasswordForgot = function (form) {
                if (form.$valid) {
                    userService.passwordforgot(form).success(
                        function (data, status) {
                            notify(data.message);
                            if (data.status) {
                                window.location = "/";
                            }
                        }
                    );
                }
            };

            // User Sign In/Out
            $scope.signOut = function () {
                userService.signout($scope).success(
                    function (data, status) {
                        notify(data.message);
                        window.location = "/";
                    }
                );

            }

            $scope.login = function (username, password) {
                userService.login(username, password).success(
                    function (data, status) {
                        notify(data.message);
                        if (data.status) {
                            window.location = "/" + locale + "/user/information/";
                        }
                    }
                );
            };

        }]);

});
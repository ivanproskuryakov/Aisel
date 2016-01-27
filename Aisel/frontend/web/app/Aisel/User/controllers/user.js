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
 * @description     UserCtrl
 */

define(['app'], function (app) {
    app.controller('UserCtrl', [
        '$scope',
        '$rootScope',
        '$state',
        'userService',
        'notify',
        'Env',
        function ($scope, $rootScope, $state, userService, notify, Env) {
            var locale = Env.currentLocale();


            // Set the default value of inputType
            $scope.inputType = 'password';

            // Hide & show password function
            $scope.hideShowPassword = function () {
                if ($scope.inputType == 'password') {
                    $scope.inputType = 'text';
                } else {
                    $scope.inputType = 'password';
                }
            };

            // User Registration
            $scope.submitRegistration = function (form) {
                if (form.$valid) {
                    var email = form.email.$modelValue;
                    var password = form.password.$modelValue;

                    userService
                        .register(email, password)
                        .success(
                            function (data, status) {
                                $scope.login(email, password);
                            }
                        );
                }
            };

            // User Password Forgot
            $scope.submitPasswordForgot = function (form) {
                if (form.$valid) {
                    userService
                        .passwordforgot(form)
                        .success(
                            function (data, status) {
                                notify('New password has been sent');
                                $state.transitionTo('userLogin', {
                                    locale: locale
                                });
                            }
                        );
                }
            };

            // User Sign In/Out
            $scope.signOut = function () {
                userService
                    .signout($scope)
                    .success(
                        function (data, status) {
                            notify('Good bye!');
                            $rootScope.user = undefined;
                            $state.transitionTo('homepage', {
                                locale: locale
                            });
                        }
                    );
            };

            $scope.login = function (email, password) {
                userService.login(email, password)
                    .success(
                        function (data, status) {
                            $rootScope.user = data.user;
                            $state.transitionTo('userInformation', {
                                locale: locale
                            });
                            notify('Hello ' + $rootScope.user.email);
                        }
                    )
            };
        }
    ]);
});

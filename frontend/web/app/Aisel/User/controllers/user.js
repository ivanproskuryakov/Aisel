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
    app.controller('UserCtrl', ['$scope', '$rootScope', '$state', 'userService', 'notify', 'Environment',
        function ($scope, $rootScope, $state, userService, notify, Environment) {
            var locale = Environment.currentLocale();

            // User Registration
            $scope.submitRegistration = function (form) {
                if (form.$valid) {
                    userService.register(form).success(
                        function (data, status) {
                            notify(data.message);
                            if (data.status) {
                                if (data.user.username) {
                                    $rootScope.user = data.user;
                                    $state.transitionTo('userInformation', {
                                        locale: locale
                                    });
                                }
                            }
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
                                $state.transitionTo('userLogin', {
                                    locale: locale
                                });
                            }
                        }
                    );
                }
            };

            // User Sign In/Out
            $scope.signOut = function () {
                userService.signout($scope).success(
                    function (data, status) {
                        notify('You have been successfully logged out!');
                        $rootScope.user = undefined;
                        $state.transitionTo('homepage', {
                            locale: locale
                        });
                    }
                );
            };

            $scope.login = function (username, password) {
                userService.login(username, password).success(
                    function (data, status) {
                        notify(data.message);
                        if (data.status) {
                            $state.transitionTo('userInformation', {
                                locale: locale
                            });
                        }
                    }
                );
            };
        }
    ]);
});

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
 * @description     UserEditCtrl
 */

define(['app'], function (app) {
    app.controller(
        'UserEditCtrl', [
            '$scope',
            '$rootScope',
            '$state',
            'userService',
            'notify',
            'Env',
            function ($scope,
                      $rootScope,
                      $state,
                      userService,
                      notify,
                      Env) {
                var locale = Env.currentLocale();

                /**
                 * changePassword
                 */
                $scope.changePassword = function (form) {
                    if (form.$valid) {
                        var password = form.password.$modelValue;
                        userService
                            .changePassword(password)
                            .success(function (data, status) {
                                    if (status === 204) {
                                        notify('Password has been changed');
                                    }
                                }
                            );
                    }
                };

                /**
                 * deleteAccount
                 */
                $scope.deleteAccount = function () {
                    var r = confirm("Are you sure?");
                    if (r == true) {
                        userService
                            .deleteAccount()
                            .success(function (data, status) {
                                    if (status === 204) {
                                        notify('Your account has been deleted');
                                        $rootScope.user = undefined;
                                        $state.transitionTo('homepage', {
                                            locale: locale
                                        });
                                    }
                                }
                            );
                    }
                };


                /**
                 * updateAccount
                 */
                $scope.updateAccount = function (form) {
                    if (form.$valid) {
                        console.log(form);
                        userService.updateAccount($rootScope.user).success(
                            function (data, status) {
                                notify('Account settings has been updated!');
                            }
                        );
                    }
                };

            }
        ]
    );
});

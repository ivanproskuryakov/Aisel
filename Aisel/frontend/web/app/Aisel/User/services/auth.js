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
 * @description     Auth service
 */

define(['app'], function (app) {
    console.log('Kernel Auth service loaded ...');

    angular.module('app')
        .service('authService', ['$uibModal',
            function ($uibModal) {
                return {
                    authenticateWithModal: function () {
                        var modalAuthInstance = $uibModal.open({
                            templateUrl: '/app/Aisel/User/views/modal/login.html',
                            controller: 'ModalAuthCtrl'
                        });
                    }
                }
            }
        ]);

    angular.module('app')
        .controller('ModalAuthCtrl', ['$scope', '$rootScope', '$state', 'userService', 'notify', 'Env',
            function ($scope, $rootScope, $state, userService, notify, Env) {
                var locale = Env.currentLocale();

                $scope.passwordForgot = function () {
                    $scope.$dismiss('close');
                    $state.transitionTo('userPasswordForgot', {
                        locale: locale
                    });
                };

                $scope.register = function () {
                    $scope.$dismiss('close');
                    $state.transitionTo('userRegister', {
                        locale: locale
                    });
                };

                $scope.login = function (email, password) {
                    userService.login(email, password).success(
                        function (data, status) {
                            if (data.user.email) {
                                $rootScope.user = data.user;
                                $scope.$dismiss('close');
                                notify('Hello ' + $rootScope.user.email + "!");
                            }
                        }
                    ).error(function (data, status) {
                        notify(data.message);
                        console.log(data);
                    });
                };
            }
        ]);
});

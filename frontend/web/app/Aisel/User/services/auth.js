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
        .service('authService', ['$http', '$rootScope', '$location', '$modal', 'Environment',
            function ($http, $rootScope, $location, $modal, Environment) {

                return {
                    authenticateWithModal: function (state, params) {
                        var modalAuthInstance = $modal.open({
                            templateUrl: '/app/Aisel/User/views/modal/login.html',
                            controller: 'ModalAuthCtrl'
                        });
                    }

                }
            }
        ]);
    angular.module('app')
        .controller('ModalAuthCtrl', ['$scope', '$rootScope', '$state', 'userService', 'notify', 'Environment',
            function ($scope, $rootScope, $state, userService, notify, Environment) {
                var locale = Environment.currentLocale();

                $scope.passwordForgot = function () {
                    $scope.$dismiss('close');
                    $state.transitionTo('userPasswordForgot', {locale: locale});
                }

                $scope.register = function () {
                    $scope.$dismiss('close');
                    $state.transitionTo('userRegister', {locale: locale});
                }

                $scope.login = function (username, password) {
                    userService.login(username, password).success(
                        function (data, status) {
                            notify(data.message);

                            if (data.status) {
                                if (data.user.username) {
                                    $rootScope.user = data.user;
                                    $scope.$dismiss('close');
                                }
                            }
                        }
                    );
                };
            }]);
})
;
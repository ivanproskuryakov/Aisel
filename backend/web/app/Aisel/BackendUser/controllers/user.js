'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselBackendUser
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('UserCtrl', ['$log', '$scope', '$rootScope', '$state', '$routeParams', 'userService', 'notify', 'Environment',
        function ($log, $scope, $rootScope, $state, $routeParams, userService, notify, Environment) {
            var locale = Environment.currentLocale();

            userService.getUserInformation($scope).success(
                function (data, status) {
                    if (data.username) {
                        $state.transitionTo('dashboard', {locale: locale});
                    }
                }
            );

            // User Sign In/Out
            $scope.signOut = function () {
                userService.signout($scope).success(
                    function (data, status) {
                        notify(data.message);
                        $rootScope.user = undefined;
                        $state.transitionTo('userLogin', {locale: locale});
                    }
                );

            }

            $scope.login = function (username, password) {
                userService.login(username, password).success(
                    function (data, status) {
                        notify(data.message);
                        if (data.status) {
                            $rootScope.user = data.user;
                            $state.transitionTo('dashboard', {locale: locale});
                        }
                    }
                );
            };

        }]);

});
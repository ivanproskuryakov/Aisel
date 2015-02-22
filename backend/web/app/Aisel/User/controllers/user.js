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
                            $state.transitionTo('home', {locale: locale});
                        }
                    }
                );
            };

        }]);

});
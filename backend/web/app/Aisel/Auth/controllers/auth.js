'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAuth
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('AuthCtrl', ['$scope', '$rootScope', '$state', 'authService', 'notify', 'Environment',
        function ($scope, $rootScope, $state, authService, notify, Environment) {
            var locale = Environment.currentLocale();

            // User Sign In/Out
            $scope.signOut = function () {
                authService.signout($scope).success(
                    function (data, status) {
                        notify('Good bye!');
                        $rootScope.user = undefined;
                        $state.transitionTo('userLogin', {
                            locale: locale
                        });
                    }
                );
            };

            $scope.login = function (username, password) {
                authService.login(username, password).success(
                    function (data, status) {
                        $rootScope.user = data.user;
                        $state.transitionTo('home', {
                            locale: locale
                        });
                        notify('Hello ' + $rootScope.user.email + "!");
                    }
                ).error(function (data, status) {
                    notify(data.message);
                    console.log(data);
                });
            };

        }
    ]);

});

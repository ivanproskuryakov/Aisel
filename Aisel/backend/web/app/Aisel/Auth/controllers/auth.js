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
    app.controller('AuthCtrl', ['$scope', '$rootScope', '$state', 'authService', 'notify', 'Env',
        function ($scope, $rootScope, $state, authService, notify, Env) {
            var locale = Env.currentLocale();

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

            $scope.login = function (email, password) {
                authService.login(email, password)
                    .success(
                        function (data, status) {


                            window.location.href = '/';
                            //$rootScope.user = data.user;
                            //$state.transitionTo('home', {
                            //    locale: locale
                            //});
                        }
                    )
                    .error(function (data, status) {
                        notify(data.message);
                        console.log(data);
                    });
            };

        }
    ]);

});

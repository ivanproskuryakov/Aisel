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
 * @description     Module config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("userLogin", {
                url: "/:locale/user/login/",
                templateUrl: '/app/Aisel/Auth/views/login.html',
                controller: 'AuthCtrl',
                data: {
                    role: 'guest'
                }
            })
    }]);

    app.run(['$http', '$state', '$rootScope', 'authService', 'Env',
        function ($http, $state, $rootScope, authService, Env) {
            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {

                var locale = Env.currentLocale();

                // If role needed
                if (typeof toState.data !== 'undefined') {
                    var role = toState.data.role;

                    if ((role === 'ROLE_ADMIN') && (role !== $rootScope.user)) {
                        event.preventDefault();
                    }

                    console.log('Needed role: ' + role);
                } else {
                    // role not needed

                    if ($rootScope.user === undefined) {
                        // Load user status
                        authService.getUserInformation().success(
                            function (data, status) {

                                if (data.email) {
                                    $rootScope.user = data;
                                } else {
                                    $rootScope.user = false;
                                    event.preventDefault();
                                    $state.transitionTo('userLogin', {
                                        locale: locale
                                    });
                                }
                                
                                console.log('----------- $stateChangцeStart: User Information Required -----------');
                                console.log($rootScope);
                            }
                        );
                    } else if ($rootScope.user == false) {
                        event.preventDefault();
                        $state.transitionTo('userLogin', {
                            locale: locale
                        });
                    }
                }
            });
        }
    ])
});

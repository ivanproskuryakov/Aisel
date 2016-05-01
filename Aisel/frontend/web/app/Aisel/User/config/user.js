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
 * @description     Module config
 */

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("userLogin", {
                url: "/:locale/user/login/",
                templateUrl: '/app/Aisel/User/views/login.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            .state("userRegister", {
                url: "/:locale/user/register/",
                templateUrl: '/app/Aisel/User/views/register.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            .state("userPasswordForgot", {
                url: "/:locale/user/password/forgot/",
                templateUrl: '/app/Aisel/User/views/password-forgot.html',
                controller: 'UserCtrl',
                data: {
                    role: 'guest'
                }
            })
            // Authenticated userInformationEdit actions
            .state("userInformation", {
                url: "/:locale/user/information/",
                templateUrl: '/app/Aisel/User/views/information/dashboard.html',
                controller: 'UserEditCtrl',
                data: {
                    role: 'user'
                }

            })
    }]);


    //Will be removed later
    app.run(['$http', '$rootScope', 'userService',
        function ($http, $rootScope, userService) {

            // Load user status
            userService.getUserInformation().success(
                function (data, status) {
                    console.log(data);
                    if (data.email) {
                        $rootScope.user = data;
                    } else {
                        $rootScope.user = undefined;
                    }
                }
            );
        }
    ]);


    app.run(['$http', '$rootScope', '$state', 'Env', 'userService',
        function ($http, $rootScope, $state, Env, userService) {

            var locale = Env.currentLocale();

            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                if (typeof toState.data !== 'undefined') {
                    console.log('Role needed: ' + toState.data.role);
                    var role = toState.data.role;

                    if (role == 'user') {
                        if ($rootScope.user === undefined) {
                            userService.getUserInformation().success(
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
                                }
                            );
                        } else if ($rootScope.user == false) {
                            event.preventDefault();

                            $state.transitionTo('userLogin', {
                                locale: locale
                            });
                        }
                    }
                }
            });
        }
    ])
});

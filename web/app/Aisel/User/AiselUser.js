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
 * @description     User module configuration
 */

define(['app',
    './controllers/user',
    './services/auth',
    './services/user/category',
    './services/user/page',
    './services/user/user',
], function (app) {
    console.log('User module loaded ...');

    app.run(['$http', '$rootScope', 'authService',
        function ($http, $rootScope, authService) {
            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                if (typeof toState.data !== 'undefined') {
                    console.log('Role needed: ' + toState.data.role);
                    var role = toState.data.role;
                    if (role == 'user' && typeof $rootScope.user === 'undefined') {
                        event.preventDefault();
                        authService.authenticateWithModal(toState.name, toParams)
                    }
                }
            });
        }])

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
            // Authenticated users actions
            .state("userInformation", {
                url: "/:locale/user/information/",
                templateUrl: '/app/Aisel/User/views/information/dashboard.html',
                controller: 'UserCtrl',
                data: {
                    role: 'user'
                }

            })
            .state("userInformationEdit", {
                url: "/:locale/user/information/edit/",
                templateUrl: '/app/Aisel/User/views/information/edit.html',
                controller: 'UserCtrl',
                data: {
                    role: 'user'
                }

            })
    }]);
});
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
 * @description     user module configuration
 */

define(['app',
    './controllers/user',
    './services/user/category', './services/user/page', './services/user/user',
], function (app) {
    console.log('User module loaded ...');
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            .state("userLogin", {
                url: "/:locale/user/login/",
                templateUrl: '/app/Aisel/User/views/login.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleGuest()
                    }
                }
            })
            .state("userRegister", {
                url: "/:locale/user/register/",
                templateUrl: '/app/Aisel/User/views/register.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleGuest()
                    }
                }
            })
            .state("userPasswordForgot", {
                url: "/:locale/user/password/forgot/",
                templateUrl: '/app/Aisel/User/views/password-forgot.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleGuest()
                    }
                }
            })
            // Authenticated users actions
            .state("userInformation", {
                url: "/:locale/user/information/",
                templateUrl: '/app/Aisel/User/views/information/dashboard.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleUser()
                    }
                }
            })
            .state("userInformationEdit", {
                url: "/:locale/user/information/edit/",
                templateUrl: '/app/Aisel/User/views/information/edit.html',
                controller: 'UserCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleUser()
                    }
                }
            })
    }]);
});
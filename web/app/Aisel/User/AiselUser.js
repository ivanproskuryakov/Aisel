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
 * @description     User module
 */

define(['app',
    './controllers/user',
    './services/auth',
    './services/user/category',
    './services/user/page',
    './services/user/user',
], function (app) {
    console.log('User module loaded ...');

    app.run(['$http', '$rootScope', 'authService', 'userService',
        function ($http, $rootScope, authService, userService) {
            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                if (typeof toState.data !== 'undefined') {
                    console.log('Role needed: ' + toState.data.role);
                    var role = toState.data.role;

                    if (role == 'user') {
                        if ($rootScope.user === undefined) {
                            userService.getUserInformation().success(
                                function (data, status) {
                                    if (data.username) {
                                        $rootScope.user = data;
                                    } else {
                                        $rootScope.user = false;
                                        event.preventDefault();
                                        authService.authenticateWithModal(toState.name, toParams)
                                    }
                                }
                            );
                        } else if ($rootScope.user == false) {
                            event.preventDefault();
                            authService.authenticateWithModal(toState.name, toParams)
                        }
                    }
                }
            });
        }])
});
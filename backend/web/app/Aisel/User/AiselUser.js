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
    './config/user',
    './controllers/user',
    './services/user',
], function (app) {
    console.log('User module loaded ...');

    app.run(['$http', '$state', '$rootScope', 'userService', 'Environment',
        function ($http, $state, $rootScope, userService, Environment) {
            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {

                var locale = Environment.currentLocale();

                if (typeof toState.data !== 'undefined') {
                    var role = toState.data.role;

                    if (role == 'guest') {
                        console.log('Role: ' + role);
                        //$state.transitionTo('home', {locale: locale});
                    }
                } else {
                    console.log('No role');

                    if ($rootScope.user === undefined) {
                        // Load user status
                        userService.getUserInformation().success(
                            function (data, status) {
                                console.log('----------- User-----------');
                                if (data.username) {
                                    $rootScope.user = data;
                                } else {
                                    $rootScope.user = false;
                                    event.preventDefault();
                                    $state.transitionTo('userLogin', {locale: locale});
                                }

                                console.log('1: ' + $rootScope.user);
                            }
                        );

                    } else if ($rootScope.user == false) {
                        console.log('2: ' + $rootScope.user);
                        event.preventDefault();
                        $state.transitionTo('userLogin', {locale: locale});
                    }
                }


            });
        }
    ])
})
;
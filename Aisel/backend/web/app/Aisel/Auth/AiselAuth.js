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
 * @description     Auth module
 */

define(['app',
    './config/auth',
    './controllers/auth',
    './services/auth',
], function(app) {
    console.log('Auth module loaded ...');

    app.run(['$http', '$state', '$rootScope', 'authService', 'Environment',
        function($http, $state, $rootScope, authService, Environment) {
            $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {

                var locale = Environment.currentLocale();

                if (typeof toState.data !== 'undefined') {
                    var role = toState.data.role;
                    console.log('Needed role: ' + role);
                } else {
                    if ($rootScope.user === undefined) {
                        // Load user status
                        authService.getUserInformation().success(
                            function(data, status) {
                                console.log('----------- User-----------');
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
            });
        }
    ])
});

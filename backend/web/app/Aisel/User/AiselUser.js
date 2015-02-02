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
    './services/user/user',
], function (app) {
    console.log('User module loaded ...');

    app.run(['$http', '$state', '$rootScope', 'userService', 'Environment',
        function ($http, $state, $rootScope, userService, Environment) {
            $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                var locale = Environment.currentLocale();
                if (typeof toState.data !== 'undefined') {
                    console.log('Role needed: ' + toState.data.role);
                    var role = toState.data.role;

                    if (role == 'user') {
                        if ($rootScope.user === undefined) {
                            event.preventDefault();
                            $state.transitionTo('userLogin', {locale: locale});
                        } else if ($rootScope.user == false) {
                            event.preventDefault();
                            $state.transitionTo('userLogin', {locale: locale});
                        }
                    }
                }
            });
        }])
});
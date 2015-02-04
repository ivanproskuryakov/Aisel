'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     Most important data are loaded here
 */

define(['app'], function (app) {
    console.log('Kernel init service loaded ...');
    angular.module('app')
        .service('initService', ['$http', '$rootScope', 'settingsService', 'userService', 'Environment',
            function ($http, $rootScope, settingsService, userService, Environment) {
                return {
                    launch: function () {
                        // Load user status
                        userService.getUserInformation().success(
                            function (data, status) {
                                console.log(data);
                                if (data.username) {
                                    $rootScope.user = data;
                                } else {
                                    $rootScope.user = undefined;
                                }
                            }
                        );

                        // Load settings data
                        settingsService.getApplicationConfig().success(
                            function (data, status) {

                                console.log('----------- Aisel Loaded! -----------');
                                var setLocale = function () {
                                    $rootScope.availableLocales = Environment.settings.locale.available;
                                    $rootScope.locale = Environment.currentLocale();
                                }

                                // Init
                                setLocale();

                                // Hook for on route change
                                $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                                    console.log('State Change ...');
                                    setLocale();
                                });
                            }
                        );
                    }
                }
            }
        ]);
});
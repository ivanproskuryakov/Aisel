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
        .service('initService', ['$http', '$rootScope', 'Environment',
            function ($http, $rootScope, Environment) {
                return {
                    launch: function () {
                        // Load settings data
                        console.log('----------- Aisel Loaded! -----------');
                        $rootScope.pageTitle = Environment.settings.pageTitle;

                        // Hook for route change
                        $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                            console.log('State Change ...');
                            $rootScope.availableLocales = Environment.settings.locale.available;
                            $rootScope.locale = Environment.currentLocale();
                        });
                    }
                }
            }
        ]);
});
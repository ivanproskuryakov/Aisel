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
 * @description     Kernel module, module contains data that we cant decompose into module
 */

define(['app',
    './services/settings',
    './services/init',
    './filters/main'
], function (app) {
    console.log('----------- Kernel Loaded! -----------');
    app.config(['$provide', '$urlRouterProvider',
        function ($provide, $urlRouterProvider) {
            $urlRouterProvider.otherwise(function ($injector, $location) {
                var Environment = $injector.get('Environment');
                console.log('Fallback to primary locale');
                $location.path('/' + Environment.settings.locale.primary + '/');
            });
        }]);
});


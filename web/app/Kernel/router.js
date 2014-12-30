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
 * @description     Main router provider defined in separate file router.js
 *                  Each module has its own router in config file.
 *                  Define only global routes in this appRouter.js file
 */

define(['app'], function (app) {

    angular.module('app').config(['$provide', '$urlRouterProvider',
        function ($provide, $urlRouterProvider) {

            $urlRouterProvider.otherwise(function ($injector, $location) {

                // Redirect to homepage if nothing was found
                var Environment = $injector.get('Environment');
                console.log('Fallback to primary locale');
                //console.log(Environment);
                $location.path('/' + Environment.settings.locale.primary + '/');
            });
        }]);
});


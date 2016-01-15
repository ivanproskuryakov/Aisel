'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            KernelResource
 * @description     Module config
 */

define(['app'], function(app) {
    app.config(['$provide', '$urlRouterProvider',
        function($provide, $urlRouterProvider) {
            $urlRouterProvider.otherwise(function($injector) {

                var Env = $injector.get('Env');
                var $state = $injector.get('$state');
                var locale = Env.locale.primary;

                console.log('Fallback to primary locale');
                $state.transitionTo('homepage', {
                    locale: locale
                });
            });
        }
    ]);

});

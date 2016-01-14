'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselNavigation
 * @description     Module configuration
 */

define(['app'], function(app) {
    app
        .config(['$stateProvider', function($stateProvider) {
            $stateProvider
                .state("navigation", {
                    url: "/:locale/navigation/:lang/",
                    templateUrl: '/app/Aisel/Kernel/views/node.html',
                    controller: 'NavigationCtrl'
                })
                .state("navigationEdit", {
                    url: "/:locale/navigation/edit/:lang/:id/",
                    templateUrl: '/app/Aisel/Navigation/views/edit-node.html',
                    controller: 'NavigationDetailCtrl'
                })

        }])
        .run(['$rootScope', 'Env', function($rootScope, Env) {
            $rootScope.topMenu.push({
                "ordering": 500,
                "roles": 'ROLE_ADMIN',
                "slug": '/navigation/' + Env.currentLocale() + '/',
                "title": 'Navigation'
            });
        }]);
});

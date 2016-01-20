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

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("navigation", {
                    url: "/:locale/navigation/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'NavigationCtrl'
                })
                .state("navigationEdit", {
                    url: "/:locale/navigation/:id/",
                    templateUrl: '/app/Aisel/Navigation/views/edit-node.html',
                    controller: 'NavigationDetailCtrl'
                })
                .state("navigationNew", {
                    url: "/:locale/navigation/edit/new/",
                    templateUrl: '/app/Aisel/Navigation/views/edit-node.html',
                    controller: 'NavigationDetailCtrl'
                })

        }])
        .run(['$rootScope', 'Env', function ($rootScope, Env) {
            $rootScope.adminMenu.push({
                "ordering": 500,
                "slug": '/navigation/',
                "title": 'Navigation'
            });
        }]);
});

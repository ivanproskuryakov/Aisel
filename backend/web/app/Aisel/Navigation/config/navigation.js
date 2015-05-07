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
                    url: "/:locale/navigation/:lang/",
                    templateUrl: '/app/Kernel/Resource/views/category.html',
                    controller: 'NavigationCtrl'
                })
                .state("navigationEdit", {
                    url: "/:locale/navigation/edit/:lang/:id/",
                    templateUrl: '/app/Aisel/Navigation/views/edit-category.html',
                    controller: 'NavigationDetailCtrl'
                })

        }])
        .run(['$rootScope', 'Environment', function ($rootScope, Environment) {
            $rootScope.topMenu.push(
                {
                    "ordering": 500,
                    "slug": '/navigation/' + Environment.currentLocale() + '/',
                    "title": 'Navigation'
                }
            );
        }]);
});
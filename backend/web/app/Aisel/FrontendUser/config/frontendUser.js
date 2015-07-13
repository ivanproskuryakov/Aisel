'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselFrontendUser
 * @description     Module configuration
 */

define(['app'], function(app) {
    app
        .config(['$stateProvider', function($stateProvider) {
            $stateProvider
                .state("frontendUsers", {
                    url: "/:locale/users/frontend/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'FrontendUserCtrl'
                })
                .state("frontendUserEdit", {
                    url: "/:locale/users/frontend/edit/:id/",
                    templateUrl: '/app/Aisel/FrontendUser/views/edit.html',
                    controller: 'FrontendUserDetailCtrl'
                })
                .state("frontendUserNew", {
                    url: "/:locale/users/frontend/new/",
                    templateUrl: '/app/Aisel/Product/views/edit.html',
                    controller: 'FrontendUserDetailCtrl'
                })
        }])
        .run(['$rootScope', 'Environment', function($rootScope, Environment) {
            $rootScope.topMenu.push({
                "ordering": 300,
                "title": 'Users',
                "slug": '/users/frontend/'
            });
        }]);
});

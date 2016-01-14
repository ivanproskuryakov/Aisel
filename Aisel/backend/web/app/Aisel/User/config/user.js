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
 * @description     Module configuration
 */

define(['app'], function (app) {
    app
        .config(['$stateProvider', function ($stateProvider) {
            $stateProvider
                .state("users", {
                    url: "/:locale/users/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'UserCtrl'
                })
                .state("userEdit", {
                    url: "/:locale/users/edit/:id/",
                    templateUrl: '/app/Aisel/User/views/edit.html',
                    controller: 'UserDetailCtrl'
                })
                .state("userNew", {
                    url: "/:locale/users/new/",
                    templateUrl: '/app/Aisel/User/views/edit.html',
                    controller: 'UserDetailCtrl'
                })
        }])
        .run(['$rootScope', 'Env', function ($rootScope, Env) {
            $rootScope.adminMenu.push({
                "ordering": 300,
                "title": 'Users',
                "slug": '/users/'
            });
        }]);
});

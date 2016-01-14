'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselOrder
 * @description     Module configuration
 */

define(['app'], function(app) {
    app
        .config(['$stateProvider', function($stateProvider) {
            $stateProvider
                .state("orders", {
                    url: "/:locale/orders/",
                    templateUrl: '/app/Aisel/Kernel/views/collection.html',
                    controller: 'OrderCtrl'
                })
                .state("orderEdit", {
                    url: "/:locale/order/edit/:id/",
                    templateUrl: '/app/Aisel/Order/views/edit.html',
                    controller: 'OrderDetailsCtrl'
                })
        }])
        .run(['$rootScope', 'Env', function($rootScope, Env) {
            $rootScope.adminMenu.push({
                "ordering": 400,
                "slug": '/orders/',
                "title": 'Orders'
            });
        }]);
});

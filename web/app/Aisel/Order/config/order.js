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

define(['app'], function (app) {
    app.config(['$stateProvider', function ($stateProvider) {
        $stateProvider
            // Authenticated users actions
            .state("orders", {
                url: "/:locale/user/orders/",
                templateUrl: '/app/Aisel/Order/views/order.html',
                controller: 'OrderCtrl',
                data: {
                    role: 'user'
                }
            })
            .state("viewOrder", {
                url: "/:locale/user/order/view/:orderId/",
                templateUrl: '/app/Aisel/Order/views/order-detail.html',
                controller: 'OrderDetailCtrl',
                data: {
                    role: 'user'
                }
            })
    }]);
});
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
 * @description     order module configuration
 */

define(['app',
    './controllers/order',
    './controllers/orderDetail',
    './services/order',
], function (app) {
    console.log('Order module loaded ...');
    app.config(function ($provide, $routeProvider) {
        $routeProvider
            .when('/:locale/user/orders/', {
                templateUrl: '/app/Aisel/Order/views/order.html',
                controller: 'OrderCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleUser()
                    }
                }
            })
            .when('/:locale/user/order/view/:orderId/', {
                templateUrl: '/app/Aisel/Order/views/order-detail.html',
                controller: 'OrderDetailCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleUser()
                    }
                }
            })
    });
});
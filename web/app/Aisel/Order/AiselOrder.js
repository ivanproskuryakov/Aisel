'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Order router
 */

define(['app',
    './controllers/order',
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
            .when('/:locale/user/order/view/:id/', {
                templateUrl: '/app/Aisel/Order/views/order-detail.html',
                controller: 'OrderCtrl',
                resolve: {
                    factory: function (authService) {
                        authService.roleUser()
                    }
                }
            })
    });
});
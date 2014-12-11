'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @ngdoc           overview
 * @name            Aisel
 * @description     Cart router
 */

define(['app',
    './controllers/cart',
    './services/cart',
], function (app) {
    console.log('Cart module loaded ...');
    app.config(function ($provide, $routeProvider) {
        $routeProvider
            // Cart
            .when('/:locale/cart/', {
                templateUrl: '/app/Aisel/Cart/views/cart.html',
                controller: 'CartCtrl'
            })
    });
});
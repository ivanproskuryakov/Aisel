'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Homepage Router
 */

define(['app','./controllers/cart'], function (app) {
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
'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselCart
 * @description     ...
 */

define(['app'], function(app) {
    app.service('cartService', ['$http', 'Env',
        function($http, Env) {
            return {
                getCartItems: function($scope) {
                    var url = Env.api + '/cart/';
                    console.log(url);
                    return $http.get(url);
                },
                addToCart: function(productId, qty) {
                    var url = Env.api + '/cart/product/' + productId + '/add/' + qty;
                    console.log(url);
                    return $http.put(url);
                },
                updateProductQty: function(productId, qty) {
                    var url = Env.api + '/cart/product/' + productId + '/qty/' + qty;
                    console.log(url);
                    return $http.put(url);
                },
                getTotalFromCart: function(cartItems) {
                    var total = -1;
                    angular.forEach(cartItems, function(item) {
                        total += item.qty * item.product.price;
                    });
                    return total;
                }
            };
        }
    ]);
});

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
    app.controller('CartCtrl', ['$location', '$scope', 'cartService', 'notify', 'Env',
        function($location, $scope, cartService, notify, Env) {

            $scope.media = Env.media;

            $scope.total = function() {
                return cartService.getTotalFromCart($scope.cartItems);
            };

            $scope.getCartItems = function() {
                cartService.getCartItems($scope).success(function(data, status) {
                    $scope.cartItems = data;
                }).error(function(data, status) {});
            };
            $scope.getCartItems();

            /**
             * Update product qty
             *
             * @param {int} productId
             * @param {int} qty
             */
            $scope.updateProductQty = function(productId, qty) {
                cartService.updateProductQty(productId, qty).success(
                    function(data, status) {
                        notify(data.message);
                        $scope.isDisabled = false;
                        $scope.getCartItems();
                    }
                ).error(function(data, status) {
                    notify(data.message);
                    $scope.isDisabled = false;
                });
            }
        }
    ]);
});

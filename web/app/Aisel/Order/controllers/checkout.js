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
 * @description     checkout & order submit controller
 */

define(['app'], function (app) {
    app.controller('CheckoutCtrl', ['$location', '$scope', 'orderService', 'notify', 'cartService', 'checkoutService', 'checkoutSettings',
        function ($location, $scope, orderService, notify, cartService, checkoutService, checkoutSettings) {

            $scope.checkoutSettings = checkoutSettings.data;

            $scope.getCartItems = cartService.getCartItems($scope).success(
                function (data, status) {
                    $scope.cartItems = data;
                }
            )

            $scope.total = function () {
                return cartService.getTotalFromCart($scope.cartItems);
            }

            // Submit order button
            $scope.orderSubmit = function () {
                if ($scope.cartItems) {
                    $scope.isDisabled = true;
                    checkoutService.orderSubmit()
                        .success(function (data, status) {
                            notify(data.message);
                        })
                        .error(function (data, status) {
                            notify(data.message);
                        })
                        .then(function () {
                            $scope.isDisabled = false;
                            $scope.getCartItems;
                        });
                }
            };
        }]);
});
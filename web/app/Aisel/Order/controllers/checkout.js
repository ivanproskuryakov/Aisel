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

            $scope.checkout = {
                settings: checkoutSettings.data,
                address: {}
            };

            // === Cart Items & Totals ===
            $scope.getCartItems = cartService.getCartItems($scope).success(
                function (data, status) {
                    $scope.cartItems = data;
                }
            )
            $scope.getTotal = function () {
                return cartService.getTotalFromCart($scope.cartItems);
            }

            // === Billing Address Suggestions ===
            checkoutService.getCountries().success(function (response) {
                $scope.countries = response;
            });
            $scope.onSelectCountry = function ($item, $model, $label) {
                $scope.checkout.address.country = $item;
                console.log($scope.checkout.address);

                checkoutService.getRegions($scope.checkout.address.country).success(function (response) {
                    $scope.regions = response;
                });
            };
            $scope.onSelectRegion = function ($item, $model, $label) {
                $scope.checkout.address.region = $item;
                console.log($scope.checkout.address);

                checkoutService.getCities($scope.checkout.address.region).success(function (response) {
                    $scope.cities = response;
                });
            };
            $scope.onSelectCity = function ($item, $model, $label) {
                $scope.checkout.address.city = $item;
                console.log($scope.checkout.address);
            };

            // === Submit Order ===
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
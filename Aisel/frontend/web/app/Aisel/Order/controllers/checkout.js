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

define(['app'], function(app) {
    app.controller('CheckoutCtrl', ['$location', '$scope', '$state', 'orderService', 'notify', 'cartService', 'checkoutService', 'checkoutSettings', 'Env',
        function($location, $scope, $state, orderService, notify, cartService, checkoutService, checkoutSettings, Env) {

            var locale = Env.currentLocale();
            $scope.checkout = {
                settings: checkoutSettings.data,
                address: {},
                selected: {
                    payment_method: 'offline',
                    billing_country: '',
                    billing_region: '',
                    billing_city: '',
                    billing_phone: '',
                    billing_comment: ''
                }
            };

            // === Cart Items & Totals ===
            $scope.getCartItems = cartService.getCartItems($scope).success(
                function(data, status) {
                    $scope.cartItems = data;
                }
            );
            $scope.getTotal = function() {
                return cartService.getTotalFromCart($scope.cartItems);
            };

            // === Billing Address Suggestions ===
            checkoutService.getCountries().success(function(response) {
                $scope.countries = response.collection;
            });
            $scope.onSelectCountry = function($item, $model, $label) {
                $scope.checkout.address.country = $item;
                console.log($scope.checkout.address);

                checkoutService.getRegions($scope.checkout.address.country).success(function(response) {
                    $scope.regions = response.collection;
                });
            };
            $scope.onSelectRegion = function($item, $model, $label) {
                $scope.checkout.address.region = $item;
                console.log($scope.checkout.address);

                checkoutService.getCities($scope.checkout.address.region).success(function(response) {
                    $scope.cities = response.collection;
                });
            };
            $scope.onSelectCity = function($item, $model, $label) {
                $scope.checkout.address.city = $item;
                console.log($scope.checkout.address);
            };

            // === Submit Order ===
            $scope.orderSubmit = function(form) {
                if (form.$valid && $scope.cartItems) {
                    $scope.isDisabled = true;
                    checkoutService.orderSubmit(form)
                        .success(function(data, status) {
                            $scope.isDisabled = true;
                            $state.transitionTo('orders', {
                                locale: locale
                            });
                            notify(data.message);
                        })
                        .error(function(data, status) {
                            notify(data.message);
                            $scope.isDisabled = false;
                        })
                        .then(function() {
                            $scope.isDisabled = false;
                            $scope.getCartItems;
                        });
                }
            };
        }
    ]);
});

'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductDetailCtrl',
        ['$scope', '$location', '$stateParams', 'productService', '$rootScope',
            'cartService', 'notify', 'Environment', 'authService',
            function ($scope, $location, $stateParams, productService, $rootScope,
                      cartService, notify, Environment, authService) {

                $scope.media = Environment.settings.media;
                $scope.isDisabled = true;

                var productURL = $stateParams.productId;
                productService.getProductByURL(productURL).success(
                    function (data, status) {
                        $scope.product = data;
                        $rootScope.productTitle = $scope.title;
                        $scope.isDisabled = false;

                        window.disqus_shortname = $rootScope.disqusShortname;
                        $scope.showComments = false;
                    }
                );

                /**
                 * Add product to cart
                 *
                 * @param {int} productId
                 * @param {int} qty
                 */
                $scope.addToCart = function (productId, qty) {

                    // if user is a guest - redirect or login page
                    if (typeof $rootScope.user === 'undefined') {
                        authService.authenticateWithModal();
                    } else {
                        $scope.isDisabled = true;
                        cartService.addToCart(productId, qty).success(
                            function (data, status) {
                                notify(data.message);
                                $scope.isDisabled = false;
                            }
                        ).error(function (data, status) {
                                notify(data.message);
                                $scope.isDisabled = false;
                            });
                    }
                };

            }]);
});
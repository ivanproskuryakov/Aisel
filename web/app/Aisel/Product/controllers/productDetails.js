'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('ProductDetailCtrl', ['$scope', '$routeParams', 'productService', '$rootScope', 'cartService', 'notify',
        function ($scope, $routeParams, productService, $rootScope, cartService, notify) {
            $scope.isDisabled = true;

            var productURL = $routeParams.productId;
            var handleSuccess = function (data, status) {
                $scope.productDetails = data;
                $rootScope.productTitle = $scope.productDetails.product.title;

                if ($scope.productDetails.product) {
                    $scope.isDisabled = false;
                }
                // Disqus comments
                window.disqus_shortname = $rootScope.disqusShortname;
                $scope.showComments = $rootScope.disqusStatus && $scope.productDetails.product.comment_status;
            };
            productService.getProductByURL(productURL).success(handleSuccess);

            // Add product to cart
            $scope.addToCart = function () {
                $scope.isDisabled = true;
                cartService.addToCart($scope).success(
                    function (data, status) {
                        notify(data.message);
                        $scope.isDisabled = false;
                    }
                );
            };

        }]);
});
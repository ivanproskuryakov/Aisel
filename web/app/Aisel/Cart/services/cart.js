'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('cartService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getCartItems: function ($scope) {
                    var url = API_URL + '/cart.json';
                    console.log(url);
                    return $http.get(url);
                },
                addToCart: function ($scope) {
                    var qty = 1;
                    var productId = $scope.productDetails.product.id;
                    var url = API_URL + '/cart/product/' + productId + '/qty/' + qty + '/add.json';
                    console.log(url);
                    return $http.get(url);
                },
                updateInCart: function ($scope) {
                    var qty = 1;
                    var productId = $scope.productDetails.product.id;
                    var url = API_URL + '/cart/product/' + productId + '/qty/' + qty + '/update.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});
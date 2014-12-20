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

define(['app'], function (app) {
    app.service('cartService', ['$http', 'API_URL',
        function ($http, API_URL) {
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
                    return $http.post(url);
                },
                updateInCart: function (item) {
                    var qty = item.qty;
                    var productId = item.product.id;
                    var url = API_URL + '/cart/product/' + productId + '/qty/' + qty + '/update.json';
                    console.log(url);
                    return $http.put(url);
                },
                orderSubmit: function () {
                    var locale = Aisel.getLocale();
                    var url = API_URL + '/' + locale + '/order/submit.json';
                    console.log(url);
                    return $http.post(url);
                }
            };
        }]);
});
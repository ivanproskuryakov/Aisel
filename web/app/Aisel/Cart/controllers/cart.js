'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */
define(['app'], function (app) {
    app.controller('CartCtrl', ['$location', '$scope', 'cartService', '$rootScope',
        function ($location, $scope, cartService, $rootScope) {
            // Get cart items
            cartService.getCartItems($scope).success(
                function (data, status) {
                    $scope.cartItems = data;
                }
            );
        }]);
});
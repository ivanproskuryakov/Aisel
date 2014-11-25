'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */
define(['app'], function (app) {
    app.controller('OrderCtrl', ['$location', '$scope', 'orderService',
        function ($location, $scope, orderService) {
            // Get user orders
            orderService.getOrders($scope).success(
                function (data, status) {
                    $scope.orders = data;
                }
            );
        }]);
});
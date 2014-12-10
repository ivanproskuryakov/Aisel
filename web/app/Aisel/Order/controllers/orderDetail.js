'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */
define(['app'], function (app) {
    app.controller('OrderDetailCtrl', ['$location', '$scope', 'orderService', '$routeParams',
        function ($location, $scope, orderService, $routeParams) {
            $scope.orderId = $routeParams.orderId;
            var handleSuccess = function (data, status) {
                $scope.orderDetails = data[0];
            };
            orderService.getOrder($scope.orderId).success(handleSuccess);
        }]);
});
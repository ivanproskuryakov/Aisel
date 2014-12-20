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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('OrderDetailCtrl', ['$location', '$scope', 'orderService', '$stateParams',
        function ($location, $scope, orderService, $stateParams) {
            $scope.orderId = $stateParams.orderId;
            var handleSuccess = function (data, status) {
                $scope.orderDetails = data[0];
            };
            orderService.getOrder($scope.orderId).success(handleSuccess);
        }]);
});
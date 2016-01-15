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
    app.controller('OrderDetailCtrl', ['$location', '$scope', 'orderService', '$stateParams', 'Env',
        function ($location, $scope, orderService, $stateParams, Env) {
            $scope.media = Env.media;
            $scope.orderId = $stateParams.orderId;

            orderService
                .getOrder($scope.orderId)
                .success(function (data, status) {
                    console.log(data[0]);
                    $scope.orderDetails = data;
                });
        }
    ]);
});

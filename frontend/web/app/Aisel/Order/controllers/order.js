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

define(['app'], function(app) {
    app.controller('OrderCtrl', ['$location', '$scope', 'orderService',
        function($location, $scope, orderService) {
            // Get user orders
            orderService.getOrders().success(
                function(data, status) {
                    $scope.orders = data;
                    console.log($scope.orders);

                }
            );
        }
    ]);
});

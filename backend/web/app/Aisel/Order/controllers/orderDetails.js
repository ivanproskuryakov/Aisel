'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     OrderDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('OrderDetailsCtrl', function ($controller, $scope, orderService) {

        $scope.route = {
            name: 'Order',
            collection: 'orders',
            edit: 'orderEdit'
        };

        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: orderService
        }));

    });
});
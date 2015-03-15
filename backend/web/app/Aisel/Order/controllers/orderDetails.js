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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('OrderDetailsCtrl', function ($scope, $stateParams, orderService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Order'
        };
        var handleSuccess = function (data, status) {
            $scope.item = {};
            $scope.item.item = data;
        };
        orderService.get($scope.details.id).success(handleSuccess);

        $scope.editCancel = function () {
            $state.transitionTo('orders', {locale: Environment.currentLocale()});
        }
    });
});
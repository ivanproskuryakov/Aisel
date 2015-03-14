'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAddressing
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('AddressingCityDetailsCtrl', function ($scope, $stateParams, cityService, $state, Environment) {
        $scope.details = {
            id: $stateParams.id,
            name: 'City'
        };
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        cityService.get($scope.details.id).success(handleSuccess);

        $scope.editCancel = function () {
            $state.transitionTo('cities', {locale: Environment.currentLocale()});
        }
    });
});
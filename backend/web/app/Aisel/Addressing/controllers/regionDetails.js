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
    app.controller('AddressingRegionDetailsCtrl', function ($scope, $stateParams, regionService, $rootScope) {
        var id = $stateParams.id;
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        regionService.get(id).success(handleSuccess);
    });
});
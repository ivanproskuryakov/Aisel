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
    app.controller('AddressingCountryDetailsCtrl', function ($scope, $stateParams, countryService, $rootScope) {
        var id = $stateParams.id;
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        countryService.get(id).success(handleSuccess);
    });
});
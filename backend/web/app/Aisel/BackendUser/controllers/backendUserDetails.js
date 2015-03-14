'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselBackendUser
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('BackendUserDetailCtrl', function ($scope, $stateParams, backendUserService, $state, Environment) {
        $scope.details = {
            id: $stateParams.id,
            name: 'Backend User'
        };
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        backendUserService.get($scope.details.id).success(handleSuccess);

        $scope.editCancel = function () {
            $state.transitionTo('backendUsers', {locale: Environment.currentLocale()});
        }
    });
});
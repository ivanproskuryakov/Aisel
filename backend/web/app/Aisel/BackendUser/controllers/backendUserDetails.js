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
    app.controller('backendUserDetailCtrl', function ($scope, $stateParams, pageService, $rootScope) {
        var id = $stateParams.id;
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        pageService.get(id).success(handleSuccess);
    });
});
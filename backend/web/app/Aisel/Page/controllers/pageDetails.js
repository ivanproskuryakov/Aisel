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
    app.controller('PageDetailCtrl', function ($scope, $stateParams, pageService, $rootScope) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Page'
        };
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        pageService.get($scope.details.id).success(handleSuccess);
    });
});
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
 * @description     BackendUserDetailCtrl
 */

define(['app'], function (app) {
    app.controller('BackendUserDetailCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Backend User',
            collection: 'backendUsers',
            edit: 'backendUserEdit'
        };

        var itemService = new resourceService('backenduser');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});
'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselUser
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('UserDetailCtrl', function($controller, $scope, resourceService) {

        $scope.route = {
            name: 'User',
            collection: 'users',
            edit: 'productEdit'
        };

        var itemService = new resourceService('user');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

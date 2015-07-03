'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselFrontendUser
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('FrontendUserDetailCtrl', function($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Frontend User',
            collection: 'frontendUsers',
            edit: 'productEdit'
        };

        var itemService = new resourceService('frontenduser');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

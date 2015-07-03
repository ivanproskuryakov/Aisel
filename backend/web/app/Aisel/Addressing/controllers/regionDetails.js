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
 * @description     AddressingRegionDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('AddressingRegionDetailsCtrl', function($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Region',
            collection: 'regions',
            edit: 'regionEdit'
        };

        var itemService = new resourceService('addressing/region');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

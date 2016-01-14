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
 * @description     AddressingCityDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('AddressingCityDetailsCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'City',
            collection: 'cities',
            edit: 'cityEdit'
        };

        var itemService = new resourceService('addressing/city');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

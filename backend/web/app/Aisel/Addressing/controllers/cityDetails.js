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
    app.controller('AddressingCityDetailsCtrl', function ($controller, $scope, cityService) {

        $scope.route = {
            name: 'City',
            collection: 'cities',
            edit: 'cityEdit'
        };

        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: cityService
        }));

    });
});
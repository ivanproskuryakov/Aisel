'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselNavigation
 * @description     NavigationDetailCtrl
 */

define(['app'], function (app) {
    app.controller('NavigationDetailCtrl', function ($controller, $scope, resourceService) {

        $scope.route = {
            name: 'Navigation',
            collection: 'navigation',
            edit: 'navigationEdit'
        };

        var itemService = new resourceService('navigation');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});
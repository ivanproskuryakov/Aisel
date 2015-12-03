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
 * @description     PageReviewDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('PageReviewDetailsCtrl', function($controller, $scope, resourceService, $stateParams) {

        $scope.route = {
            name: 'Review',
            collection: 'pages',
            edit: 'pageEdit'
        };

        var itemService = new resourceService('page');
        angular.extend(this, $controller('AbstractDetailsNodeCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

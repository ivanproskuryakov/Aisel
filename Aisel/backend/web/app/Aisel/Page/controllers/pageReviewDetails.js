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
            name: 'Page Review',
            collection: 'pageReviews',
            edit: 'pageReviewEdit'
        };

        var itemService = new resourceService('page/review');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

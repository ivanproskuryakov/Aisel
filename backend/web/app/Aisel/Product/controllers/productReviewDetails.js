'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ProductReviewDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('ProductReviewDetailsCtrl', function($controller, $scope, resourceService, $stateParams) {

        $scope.route = {
            name: 'Product Review',
            collection: 'productReviews',
            edit: 'productReviewEdit'
        };

        var itemService = new resourceService('product/review');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

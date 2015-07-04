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
 * @description     ProductDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('ProductDetailsCtrl', function($controller, $scope, resourceService, Environment) {

        $scope.route = {
            name: 'Product',
            collection: 'products',
            edit: 'productEdit'
        };

        $scope.uploadPath = Environment.settings.api + '/product/image/upload/';

        var itemService = new resourceService('product');
        angular.extend(this, $controller('AbstractDetailsCategoryCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

    });
});

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

define(['app'], function (app) {
    app.controller('ProductDetailsCtrl', function ($controller, $scope, productService) {

        $scope.route = {
            name: 'Product',
            collection: 'product',
            edit: 'productEdit'
        };

        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: productService
        }));

    });
});
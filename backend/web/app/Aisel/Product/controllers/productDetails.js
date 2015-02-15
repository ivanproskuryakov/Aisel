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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductDetailCtrl', function ($scope, $stateParams, productService, $rootScope) {
        var id = $stateParams.id;
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        productService.get(id).success(handleSuccess);
    });
});
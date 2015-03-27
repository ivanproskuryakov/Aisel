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
 * @description     ProductCategoryDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('ProductCategoryDetailsCtrl', function ($scope, $stateParams, productService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Product Сategory'
        };

        productService.getCategory($scope.details.id).success(
            function (data, status) {
                $scope.item = data;
            }
        );

        $scope.editCancel = function () {
            $state.transitionTo('productCategory', {locale: Environment.currentLocale()});
        }
    });
});
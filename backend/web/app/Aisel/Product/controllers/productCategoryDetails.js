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
    app.controller('ProductCategoryDetailsCtrl', function ($controller, $stateParams, $state, Environment, $scope, resourceService) {

        $scope.route = {
            name: 'Product Category',
            collection: 'productCategory',
            edit: 'productCategoryEdit'
        };

        var itemService = new resourceService('product/category');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

        // CANCEL
        $scope.editCancel = function () {
            $state.transitionTo(
                $scope.route.collection, {
                    locale: Environment.currentLocale(),
                    lang: $stateParams.lang
                }
            );
        };

    });
});
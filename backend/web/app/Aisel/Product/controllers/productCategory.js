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
 * @description     ProductCategoryCtrl
 */

define(['app'], function (app) {
    app.controller('ProductCategoryCtrl', function ($scope, $stateParams, pageService, $state, Environment) {

        $scope.sectionName = 'Product categories';
        $scope.categoryJson = Environment.settings.api + '/product/category/';
    });
});
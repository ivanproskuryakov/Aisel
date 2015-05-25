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
    app.controller('ProductCategoryCtrl', function ($scope, $stateParams, $state, Environment) {

        $scope.sectionName = 'Product categories';
        $scope.categoryJson = Environment.settings.api + '/product/category/?locale=' + $stateParams.lang;
        $scope.categoryUpdate = Environment.settings.api + '/product/category/node/?locale=' + $stateParams.lang;

        $scope.editNode = function (id) {
            $state.transitionTo('productCategoryEdit', {
                locale: Environment.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeCategoryLocale = function (lang) {
            $state.transitionTo('productCategory', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});
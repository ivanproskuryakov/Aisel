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
 * @description     PageCategoryDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('PageCategoryDetailsCtrl', function ($controller, $stateParams, $state, Environment, $scope, pageCategoryService) {

        $scope.route = {
            name: 'Page Category',
            collection: 'pageCategory',
            edit: 'pageCategoryEdit'
        };

        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: pageCategoryService
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
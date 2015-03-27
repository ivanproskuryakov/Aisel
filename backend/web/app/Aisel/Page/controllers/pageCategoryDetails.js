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
    app.controller('PageCategoryDetailsCtrl', function ($scope, $stateParams, pageService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Page Сategory'
        };

        pageService.getCategory($scope.details.id).success(
            function (data, status) {
                $scope.item = data;
            }
        );

        $scope.editCancel = function () {
            $state.transitionTo('pageCategory', {locale: Environment.currentLocale()});
        }
    });
});
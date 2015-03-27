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
 * @description     PageDetailsCtrl
 */

define(['app'], function (app) {
    app.controller('PageDetailsCtrl', function ($scope, $stateParams, pageService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Page'
        };
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        pageService.get($scope.details.id).success(handleSuccess);

        $scope.editCancel = function () {
            $state.transitionTo('pages', {locale: Environment.currentLocale()});
        }
    });
});
'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselNavigation
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('NavigationDetailCtrl', function ($scope, $stateParams, navigationService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Navigation'
        };
        var handleSuccess = function (data, status) {
            $scope.item = data;
        };
        pageService.get($scope.details.id).success(handleSuccess);

        $scope.editCancel = function () {
            $state.transitionTo('navigation', {locale: Environment.currentLocale()});
        }
    });
});
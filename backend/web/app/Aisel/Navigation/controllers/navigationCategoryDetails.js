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
 * @description     NavigationCategoryDetails
 */

define(['app'], function (app) {
    app.controller('NavigationCategoryDetails', function ($scope, $stateParams, navigationService, $state, Environment) {

        $scope.details = {
            id: $stateParams.id,
            name: 'Navigation'
        };

        navigationService.get($scope.details.id).success(
            function (data, status) {
                $scope.item = data;
            }
        );

        $scope.editCancel = function () {
            $state.transitionTo('navigation', {locale: Environment.currentLocale()});
        }
    });
});
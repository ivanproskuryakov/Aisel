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
 * @description     NavigationCtrl
 */

define(['app'], function (app) {
    app.controller('NavigationCtrl', function ($scope, $stateParams, navigationService, $state, Environment) {

        $scope.sectionName = 'Navigation';
        $scope.categoryJson = Environment.settings.api + '/navigation/?locale=' + $stateParams.lang;

        $scope.editCategory = function () {
            console.log('editCategory');
        }

        $scope.changeCategoryLocale = function (lang) {
            $state.transitionTo('navigation', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});
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
    app.controller('NavigationCtrl', function ($scope, $stateParams, $state, Environment) {

        $scope.sectionName = 'Navigation';
        $scope.categoryJson = Environment.settings.api + '/navigation/?locale=' + $stateParams.lang;
        $scope.categoryUpdate = Environment.settings.api + '/navigation/node/?locale=' + $stateParams.lang;

        $scope.editNode = function (id) {
            $state.transitionTo('navigationEdit', {
                locale: Environment.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeCategoryLocale = function (lang) {
            $state.transitionTo('navigation', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});
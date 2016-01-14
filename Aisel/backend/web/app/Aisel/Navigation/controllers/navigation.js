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

define(['app'], function(app) {
    app.controller('NavigationCtrl', function($scope, $stateParams, $state, Env) {

        $scope.sectionName = 'Navigation';
        $scope.nodeJson = Env.api + '/navigation/?locale=' + $stateParams.lang;
        $scope.nodeUpdate = Env.api + '/navigation/node/?locale=' + $stateParams.lang;

        $scope.editNode = function(id) {
            $state.transitionTo('navigationEdit', {
                locale: Env.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeNodeLocale = function(lang) {
            $state.transitionTo('navigation', {
                locale: Env.currentLocale(),
                lang: lang
            });
        };
    });
});

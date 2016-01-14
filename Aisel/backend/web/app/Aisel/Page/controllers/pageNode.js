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
 * @description     PageNodeCtrl
 */

define(['app'], function(app) {
    app.controller('PageNodeCtrl', function($scope, $stateParams, $state, Environment) {

        $scope.sectionName = 'Page nodes';
        $scope.nodeJson = Environment.api + '/page/node/?locale=' + $stateParams.lang;
        $scope.nodeUpdate = Environment.api + '/page/node/node/?locale=' + $stateParams.lang;

        $scope.editNode = function(id) {
            $state.transitionTo('pageNodeEdit', {
                locale: Environment.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeNodeLocale = function(lang) {
            $state.transitionTo('pageNode', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});

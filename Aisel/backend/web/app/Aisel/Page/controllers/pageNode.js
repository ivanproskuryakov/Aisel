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
    app.controller('PageNodeCtrl', function($scope, $stateParams, $state, Env) {

        $scope.sectionName = 'Page nodes';
        $scope.nodeJson = Env.api + '/page/node/?locale=' + $stateParams.lang;
        $scope.nodeUpdate = Env.api + '/page/node/node/?locale=' + $stateParams.lang;

        $scope.editNode = function(id) {
            $state.transitionTo('pageNodeEdit', {
                locale: Env.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeNodeLocale = function(lang) {
            $state.transitionTo('pageNode', {
                locale: Env.currentLocale(),
                lang: lang
            });
        };
    });
});

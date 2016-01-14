'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselProduct
 * @description     ProductNodeCtrl
 */

define(['app'], function(app) {
    app.controller('ProductNodeCtrl', function($scope, $stateParams, $state, Environment) {

        $scope.sectionName = 'Product nodes';
        $scope.nodeJson = Environment.api + '/product/node/?locale=' + $stateParams.lang;
        $scope.nodeUpdate = Environment.api + '/product/node/node/?locale=' + $stateParams.lang;

        $scope.editNode = function(id) {
            $state.transitionTo('productNodeEdit', {
                locale: Environment.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeNodeLocale = function(lang) {
            $state.transitionTo('productNode', {
                locale: Environment.currentLocale(),
                lang: lang
            });
        };
    });
});

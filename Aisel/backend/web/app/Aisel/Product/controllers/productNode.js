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
    app.controller('ProductNodeCtrl', function($scope, $stateParams, $state, Env) {

        $scope.sectionName = 'Product nodes';
        $scope.nodeJson = Env.api + '/product/node/?locale=' + $stateParams.lang;
        $scope.nodeUpdate = Env.api + '/product/node/node/?locale=' + $stateParams.lang;

        $scope.editNode = function(id) {
            $state.transitionTo('productNodeEdit', {
                locale: Env.currentLocale(),
                lang: $stateParams.lang,
                id: id
            });
        };

        $scope.changeNodeLocale = function(lang) {
            $state.transitionTo('productNode', {
                locale: Env.currentLocale(),
                lang: lang
            });
        };
    });
});

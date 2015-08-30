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
 * @description     PageNodeDetailsCtrl
 */

define(['app'], function(app) {
    app.controller('PageNodeDetailsCtrl', function($controller, $stateParams, $state, Environment, $scope, resourceService) {

        $scope.route = {
            name: 'Page Node',
            collection: 'pageNode',
            edit: 'pageNodeEdit'
        };

        var itemService = new resourceService('page/node');
        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

        // CANCEL
        $scope.editCancel = function() {
            $state.transitionTo(
                $scope.route.collection, {
                    locale: Environment.currentLocale(),
                    lang: $stateParams.lang
                }
            );
        };

    });
});

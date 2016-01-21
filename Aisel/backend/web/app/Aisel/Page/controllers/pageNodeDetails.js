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
    app.controller('PageNodeDetailsCtrl', function($controller, $stateParams, $state, Env, $scope, resourceService) {

        $scope.route = {
            name: 'Page Node',
            collection: 'pageNode',
            edit: 'pageNodeEdit'
        };

        var itemService = new resourceService('page/node');

        // Fetch parent nodes
        $scope.$watch('item.locale', function () {
            if ($scope.item.locale) {
                var filter = '{"locale":"' + $scope.item.locale + '"}';
                itemService.getCollection(100000, 1, filter).success(
                    function (data, status) {
                        $scope.availableNodes = data.collection;
                    }
                );
            }
        });

        angular.extend(this, $controller('AbstractDetailsCtrl', {
            $scope: $scope,
            itemService: itemService
        }));

        // CANCEL
        $scope.editCancel = function() {
            $state.transitionTo(
                $scope.route.collection, {
                    locale: Env.currentLocale(),
                    lang: $stateParams.lang
                }
            );
        };

    });
});

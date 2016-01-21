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
 * @description     NavigationDetailCtrl
 */

define(['app'], function (app) {
    app.controller('NavigationDetailCtrl',
        function ($controller,
                  $scope,
                  resourceService,
                  $state,
                  $stateParams,
                  Env) {

            $scope.route = {
                name: 'Navigation',
                collection: 'navigation',
                edit: 'navigationEdit'
            };

            var itemService = new resourceService('navigation');

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
            $scope.editCancel = function () {
                $state.transitionTo(
                    $scope.route.collection, {
                        locale: Env.currentLocale(),
                        lang: $stateParams.lang
                    }
                );
            };

        });
});

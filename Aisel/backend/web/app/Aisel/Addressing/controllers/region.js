'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselAddressing
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('AddressingRegionCtrl', ['$scope', '$state', 'Env', 'resourceService', 'collectionService',
        function($scope, $state, Env, resourceService, collectionService) {

            var itemService = new resourceService('addressing/region');

            $scope.collectionTitle = 'Regions';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [{
                name: 'id',
                enableColumnMenu: false,
                width: '200'
            }, {
                name: 'name',
                enableColumnMenu: false
            }, {
                name: 'action',
                enableSorting: false,
                enableFiltering: false,
                enableColumnMenu: false,
                width: '100',
                cellTemplate: collectionService.actionTemplate()
            }];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === Item Action ===
            $scope.editDetails = function(id) {
                $state.transitionTo('regionEdit', {
                    locale: Env.currentLocale(),
                    id: id
                });
            };
            $scope.newItem = function() {
                $state.transitionTo('regionNew', {
                    locale: Env.currentLocale()
                });
            }

            // === Load collection from remote ===
            $scope.loadCollection = function(pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            }
            $scope.loadCollection();


        }
    ]);
});

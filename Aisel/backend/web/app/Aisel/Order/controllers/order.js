'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselOrder
 * @description     OrderCtrl
 */

define(['app'], function(app) {
    app.controller('OrderCtrl', ['$scope', '$state', 'resourceService', 'Env', 'collectionService',
        function($scope, $state, resourceService, Env, collectionService) {

            var itemService = new resourceService('order');

            $scope.collectionTitle = 'Orders';
            $scope.disableNew = true;
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [{
                name: 'id',
                enableColumnMenu: false,
                width: '200'
            }, {
                name: 'status',
                enableColumnMenu: false
            }, {
                name: 'total_amount',
                enableColumnMenu: false
            }, {
                name: 'currency',
                enableColumnMenu: false
            }, {
                name: 'country',
                enableColumnMenu: false
            }, {
                name: 'region',
                enableColumnMenu: false
            }, {
                name: 'city',
                enableColumnMenu: false
            }, {
                name: 'created_at',
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
                $state.transitionTo('orderEdit', {
                    locale: Env.currentLocale(),
                    id: id
                });
            };

            // === Load collection from remote ===
            $scope.loadCollection = function(pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            };
            $scope.loadCollection();

        }
    ]);
});

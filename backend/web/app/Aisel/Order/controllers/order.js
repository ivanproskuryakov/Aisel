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

define(['app'], function (app) {
    app.controller('OrderCtrl', ['$scope', '$state', 'resourceService', 'Environment', 'collectionService',
        function ($scope, $state, resourceService, Environment, collectionService) {

            var itemService = new resourceService('order');

            $scope.collectionTitle = 'Orders';
            $scope.disableNew = true;
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'status', enableColumnMenu: false},
                {name: 'subtotal', enableColumnMenu: false},
                {name: 'grandtotal', enableColumnMenu: false},
                {name: 'currency', enableColumnMenu: false},
                {name: 'country', enableColumnMenu: false},
                {name: 'region', enableColumnMenu: false},
                {name: 'city', enableColumnMenu: false},
                {name: 'created_at', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.actionTemplate()
                }
            ];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === Item Action ===
            $scope.editDetails = function (id) {
                $state.transitionTo('orderEdit', {locale: Environment.currentLocale(), id: id});
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            };
            $scope.loadCollection();

        }]);
});
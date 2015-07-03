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
 * @description     ProductCtrl
 */

define(['app'], function(app) {
    app.controller('ProductCtrl', ['$scope', '$state', 'resourceService', 'collectionService', 'Environment',
        function($scope, $state, resourceService, collectionService, Environment) {

            var itemService = new resourceService('product');

            $scope.collectionTitle = 'Products';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [{
                name: 'id',
                enableColumnMenu: false,
                width: '100'
            }, {
                name: 'locale',
                enableColumnMenu: false,
                width: '100'
            }, {
                name: 'price',
                enableColumnMenu: false,
                width: '100'
            }, {
                name: 'name',
                enableColumnMenu: false
            }, {
                name: 'meta_url',
                enableColumnMenu: false
            }, {
                name: 'description',
                enableColumnMenu: false
            }, {
                name: 'status',
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
                $state.transitionTo('productEdit', {
                    locale: Environment.currentLocale(),
                    id: id
                });
            };
            $scope.newItem = function() {
                $state.transitionTo('productNew', {
                    locale: Environment.currentLocale()
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

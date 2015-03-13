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
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('ProductCtrl', ['$scope', '$state', 'productService', 'collectionService', 'Environment',
        function ($scope, $state, productService, collectionService, Environment) {

            $scope.collectionTitle = 'Products';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'locale', enableColumnMenu: false, width: '100'},
                {name: 'price', enableColumnMenu: false, width: '100'},
                {name: 'name', enableColumnMenu: false},
                {name: 'meta_url', enableColumnMenu: false},
                {name: 'description', enableColumnMenu: false},
                {name: 'created_at', enableColumnMenu: false},
                {name: 'status', enableColumnMenu: false},
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
                $state.transitionTo('productEdit', {locale: Environment.currentLocale(), id: id});
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, productService, pageNumber);
            }
            $scope.loadCollection();
        }]);
});
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
    app.controller('ProductCtrl', ['$location', '$state', '$scope', '$stateParams', 'productService', 'Environment', 'collectionService',
        function ($location, $state, $scope, $stateParams, productService, Environment, collectionService) {

            $scope.pageLimit = 20;
            $scope.paginationPage = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'locale', enableColumnMenu: false, width: '15%'},
                {name: 'name', enableColumnMenu: false},
                {name: 'price', enableColumnMenu: false},
                {name: 'metaUrl', enableColumnMenu: false},
                {name: 'status', enableColumnMenu: false},
                {name: 'description', enableColumnMenu: false},
                {name: 'createdAt', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.viewTemplate()
                }
            ];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === View Row ===
            $scope.viewDetails = function (id) {
                $state.transitionTo('productView', {
                    locale: Environment.currentLocale(),
                    id: id
                });
            };

            // === Load data from remote ===
            $scope.loadCollection = function () {
                productService.getCollection($scope).success(
                    function (data, status) {
                        console.log(data);
                        $scope.pageList = data;
                        $scope.gridOptions.data = data.products;
                        $scope.gridOptions.totalItems = data.total;
                    }
                );
            }
            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                loadCollection();
            };
            $scope.loadCollection();
        }]);
});
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
            $scope.pageNumber = 1;
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

            // === View Item ===
            $scope.viewDetails = function (id) {
                $state.transitionTo('productView', {locale: Environment.currentLocale(), id: id});
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, productService, pageNumber);
            }
            $scope.loadCollection();
        }]);
});
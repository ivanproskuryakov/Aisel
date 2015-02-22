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

define(['app'], function (app) {
    app.controller('AddressingCityCtrl', ['$scope', 'cityService', 'collectionService',
        function ($scope, cityService, collectionService) {

            $scope.collectionTitle = 'City';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'name', enableColumnMenu: false},
            ];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, cityService, pageNumber);
            }
            $scope.loadCollection();


        }]);
});
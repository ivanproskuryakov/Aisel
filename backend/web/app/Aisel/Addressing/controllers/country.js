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
    app.controller('AddressingCountryCtrl', ['$scope', '$state', 'Environment', 'countryService', 'collectionService',
        function ($scope, $state, Environment, countryService, collectionService) {

            $scope.collectionTitle = 'Countries';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'iso2', enableColumnMenu: false},
                {name: 'iso3', enableColumnMenu: false},
                {name: 'short_name', enableColumnMenu: false},
                {name: 'long_name', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.actionTemplate()
                }
            ];

            // === Item Action ===
            $scope.editDetails = function (id) {
                $state.transitionTo('countryEdit', {locale: Environment.currentLocale(), id: id});
            };
            $scope.newItem = function () {
                $state.transitionTo('countryNew', {locale: Environment.currentLocale()});
            }

            $scope.gridOptions = collectionService.gridOptions($scope);

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, countryService, pageNumber);
            }
            $scope.loadCollection();


        }]);
});
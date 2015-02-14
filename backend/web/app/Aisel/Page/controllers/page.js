'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselPage
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('PageCtrl', ['$location', '$state', '$scope', '$stateParams', 'pageService',
        function ($location, $state, $scope, $stateParams, pageService) {

            $scope.pageLimit = 20;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;
            $scope.gridOptions = {
                enableRowSelection: true,
                enableRowHeaderSelection: false,
                modifierKeysToMultiSelect: false,
                multiSelect: false,
                noUnselect: true,
                selectionRowHeaderWidth: 35,
                rowHeight: 35,
                showGridFooter: true,
                enableFiltering: true,
                useExternalFiltering: true,
                columnDefs: [
                    {name: 'id', width: '100'},
                    {name: 'locale', width: '15%'},
                    {name: 'title'},
                    {name: 'metaUrl'},
                    {name: 'status'},
                    {name: 'createdAt'},
                    {
                        name: 'action',
                        enableSorting: false,
                        enableFiltering: false,
                        width: '100',
                        cellTemplate: '<a class="btn btn-link" ng-click="grid.appScope.showMe()">View</button>'
                    }
                ],
                onRegisterApi: function (gridApi) {
                    $scope.gridApi = gridApi;
                    $scope.gridApi.core.on.filterChanged($scope, function () {
                        getGridFilters(this.grid);
                    });
                }
            };


            // Used in grid filtering
            var getGridFilters = function (grid) {
                var values = [];
                grid.columns.forEach(function (entry) {
                    if (entry.filters[0] !== undefined) {
                        if (entry.filters[0].term !== undefined) {
                            values[entry.field] = entry.filters[0].term;
                        } else {
                            values[entry.field] = '';
                        }
                    }
                });
                console.log(values);
            }

            // Load data from remote
            var loadGridData = function () {
                pageService.getPageList($scope).success(
                    function (data, status) {
                        console.log(data);
                        $scope.pageList = data;
                        $scope.gridOptions.data = data.pages;
                        $scope.gridOptions.totalItems = data.total;
                    }
                );
            }
            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                loadGridData();
            };
            loadGridData();

        }]);
});
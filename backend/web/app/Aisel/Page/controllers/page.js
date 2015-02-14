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
    app.controller('PageCtrl', ['$location', '$state', '$scope', '$stateParams', 'pageService', 'Environment',
        function ($location, $state, $scope, $stateParams, pageService, Environment) {

            var locale = Environment.currentLocale();
            var viewItemTemplate = '<button class="btn btn-link" ng-click="grid.appScope.showItem(row.entity.id)">' +
                'View <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';

            $scope.pageLimit = 20;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'locale', enableColumnMenu: false, width: '15%'},
                {name: 'title', enableColumnMenu: false},
                {name: 'metaUrl', enableColumnMenu: false},
                {name: 'status', enableColumnMenu: false},
                {name: 'createdAt', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: viewItemTemplate
                }
            ];
            $scope.gridOptions = {
                selectionRowHeaderWidth: 35,
                rowHeight: 35,
                showGridFooter: true,
                enableFiltering: true,
                enableSorting: false,
                useExternalFiltering: true,
                columnDefs: $scope.columns,
                onRegisterApi: function (gridApi) {
                    $scope.gridApi = gridApi;
                    $scope.gridApi.core.on.filterChanged($scope, function () {
                        getGridFilters(this.grid);
                    });
                }
            };

            // === View Row ===
            $scope.showItem = function (id) {
                $state.transitionTo('pageView', {locale: locale, id: id});
            };

            // === Grid filtering ===
            var getGridFilters = function (grid) {
                var filters = {};
                grid.columns.forEach(function (entry) {
                    if (entry.filters[0] !== undefined) {
                        if (entry.filters[0].term !== undefined) {
                            filters[entry.field] = entry.filters[0].term;
                        } else {
                            filters[entry.field] = '';
                        }
                    }
                });
                $scope.filters = JSON.stringify(filters);
            }

            // === Load data from remote ===
            $scope.loadGridData = function () {
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
            $scope.loadGridData();

        }]);
});
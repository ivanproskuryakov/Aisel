'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselKernel
 * @description     Display collections with ui-grid
 */

define(['app'], function (app) {
    console.log('Kernel collection service loaded ...');
    angular.module('app')
        .service('collectionService', ['$http', '$rootScope', 'Env', '$state',
            function ($http, $rootScope, Env, $state) {

                var filterChanged = function (grid) {
                    var filters = {};
                    grid.columns.forEach(function (entry) {
                        if (entry.filters[0] !== undefined) {
                            if (_.isString(entry.filters[0].term)) {
                                filters[entry.field] = entry.filters[0].term;
                            }
                        }
                    });

                    var filter = JSON.stringify(filters);
                    var camelCasedFilter = filter.replace(/_([a-z])/g, function (g) {
                        return g[1].toUpperCase();
                    });

                    return camelCasedFilter;
                };

                return {
                    loadCollection: function ($scope, service, pageNumber) {
                        if (pageNumber === undefined) pageNumber = 1;
                        if ($scope.filter === undefined) $scope.filter = '';
                        service.getCollection($scope.pageLimit, pageNumber, $scope.filter).success(
                            function (data, status) {
                                console.log(data);
                                $scope.gridOptions.data = data.collection;
                                $scope.gridOptions.totalItems = data.total;
                            }
                        );
                    },
                    gridOptions: function ($scope) {
                        return {
                            selectionRowHeaderWidth: 35,
                            rowHeight: $scope.rowHeight || 35,
                            showGridFooter: true,
                            enableFiltering: true,
                            enableSorting: false,
                            useExternalFiltering: true,
                            columnDefs: $scope.columns,
                            onRegisterApi: function (gridApi) {
                                $scope.gridApi = gridApi;
                                $scope.gridApi.core.on.filterChanged($scope, function () {
                                    $scope.filter = filterChanged(this.grid);
                                });
                            }
                        }
                    },
                    actionTemplate: function () {
                        return '<ng-include src="\'/app/Aisel/Kernel/views/collection/action.html\'"></ng-include>';
                    },
                    viewTemplate: function () {
                        return '<ng-include src="\'/app/Aisel/Kernel/views/collection/view.html\'"></ng-include>';
                    }
                }
            }
        ]);
});

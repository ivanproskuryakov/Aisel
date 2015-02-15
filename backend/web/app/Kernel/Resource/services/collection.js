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
        .service('collectionService', ['$http', '$rootScope', 'Environment', '$state',
            function ($http, $rootScope, Environment, $state) {

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

                    return filter;
                }

                return {
                    gridOptions: function ($scope) {
                        return {
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
                                    $scope.filter = filterChanged(this.grid);
                                });
                            }
                        }
                    },
                    viewTemplate: function () {
                        return '<button class="btn btn-link" ng-click="grid.appScope.viewDetails(row.entity.id)">' +
                        'View <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
                    }
                }
            }
        ]);
});
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
 * @description     PageNodeCtrl
 */

define(['app'], function(app) {
    app.controller('PageNodeCtrl', [
        '$state',
        '$scope',
        'resourceService',
        'collectionService',
        'Env',
        'notify',
        function ($state,
                  $scope,
                  resourceService,
                  collectionService,
                  Env,
                  notify) {

            var itemService = new resourceService('page/node');

            $scope.collectionTitle = 'Page Nodes';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;

            $scope.columns = [{
                name: 'id',
                enableColumnMenu: false,
                width: '75'
            }, {
                name: 'locale',
                enableColumnMenu: false,
                width: '75'
            }, {
                name: 'name',
                enableColumnMenu: false
            }, {
                name: 'meta_url',
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
            $scope.editDetails = function (id) {
                $state.transitionTo('pageNodeEdit', {
                    locale: Env.currentLocale(),
                    id: id
                });
            };
            $scope.newItem = function () {
                $state.transitionTo('pageNodeNew', {
                    locale: Env.currentLocale()
                });
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            };
            $scope.loadCollection();

        }
    ]);
});

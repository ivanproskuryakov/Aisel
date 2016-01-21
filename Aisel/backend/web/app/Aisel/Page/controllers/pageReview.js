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
 * @description     PageReviewCtrl
 */

define(['app'], function (app) {
    app.controller('PageReviewCtrl',
        [
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

                var itemService = new resourceService('page/review');

                $scope.collectionTitle = 'Page Reviews';
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
                    enableColumnMenu: false,
                    width: '200'
                }, {
                    name: 'user.email',
                    enableColumnMenu: false,
                    width: '200'
                }, {
                    name: 'content',
                    enableColumnMenu: false
                }, {
                    name: 'created_at',
                    enableColumnMenu: false,
                    width: '150'
                }, {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.actionTemplate()
                }];

                $scope.gridOptions = collectionService.gridOptions($scope);
                $scope.disableNew = true;

                // === Item Action ===
                $scope.editDetails = function (id) {
                    $state.transitionTo('pageReviewEdit', {
                        locale: Env.currentLocale(),
                        id: id
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

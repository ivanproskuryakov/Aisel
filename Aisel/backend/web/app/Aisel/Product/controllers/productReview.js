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
 * @description     ProductReviewCtrl
 */

define(['app'], function (app) {
    app.controller('ProductReviewCtrl',
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

                var itemService = new resourceService('product/review');

                $scope.collectionTitle = 'Product Reviews';
                $scope.productLimit = 20;
                $scope.productNumber = 1;

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
                    $state.transitionTo('productReviewEdit', {
                        locale: Env.currentLocale(),
                        id: id
                    });
                };

                // === Load collection from remote ===
                $scope.loadCollection = function (productNumber) {
                    collectionService.loadCollection($scope, itemService, productNumber);
                };
                $scope.loadCollection();

            }
        ]);
});

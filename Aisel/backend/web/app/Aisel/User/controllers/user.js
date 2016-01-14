'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselUser
 * @description     ...
 */

define(['app'], function(app) {
    app.controller('UserCtrl', ['$scope', '$state', 'Env', 'resourceService', 'collectionService',
        function($scope, $state, Env, resourceService, collectionService) {

            var itemService = new resourceService('user');

            $scope.collectionTitle = 'Users';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [{
                name: 'id',
                enableColumnMenu: false,
                width: '200'
            }, {
                name: 'roles',
                enableColumnMenu: false,
                width: '200'
            }, {
                name: 'email',
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

            console.log($scope.gridOptions);

            // === Item Actions ===
            $scope.editDetails = function(id) {
                $state.transitionTo('userEdit', {
                    locale: Env.currentLocale(),
                    id: id
                });
            };
            $scope.newItem = function() {
                $state.transitionTo('userNew', {
                    locale: Env.currentLocale()
                });
            };

            // === Load collection from remote ===
            $scope.loadCollection = function(pageNumber) {
                collectionService.loadCollection($scope, itemService, pageNumber);
            };
            $scope.loadCollection();

        }
    ]);
});

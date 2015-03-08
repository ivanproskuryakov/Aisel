'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselFrontendUser
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('FrontendUserCtrl', ['$scope', '$state', 'Environment', 'frontendUserService', 'collectionService',
        function ($scope, $state, Environment, frontendUserService, collectionService) {

            $scope.collectionTitle = 'Frontend Users';
            $scope.pageLimit = 20;
            $scope.pageNumber = 1;
            $scope.columns = [
                {name: 'id', enableColumnMenu: false, width: '100'},
                {name: 'username', enableColumnMenu: false},
                {name: 'email', enableColumnMenu: false},
                {
                    name: 'action',
                    enableSorting: false,
                    enableFiltering: false,
                    enableColumnMenu: false,
                    width: '100',
                    cellTemplate: collectionService.viewTemplate()
                }
            ];
            $scope.gridOptions = collectionService.gridOptions($scope);

            // === View Item ===
            $scope.viewDetails = function (id) {
                $state.transitionTo('frontendUserView', {locale: Environment.currentLocale(), id: id});
            };

            // === Load collection from remote ===
            $scope.loadCollection = function (pageNumber) {
                collectionService.loadCollection($scope, frontendUserService, pageNumber);
            }
            $scope.loadCollection();

        }]);
});
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
 * @description     AbstractCollectionCtrl
 */

define(['app'], function (app) {
    app.controller('AbstractCollectionCtrl',
        function ($controller, $scope, $stateParams, itemService, $state, Env, notify) {

            if (!$scope.pageLimit) {
                $scope.pageLimit = 5;
            }
            if (!$scope.paginationPage) {
                $scope.paginationPage = 1;
            }
            if (!$scope.categoryId) {
                $scope.categoryId = 0;
            }

            /**
             * Load collection
             *
             * @param limit
             * @param page
             * @param categoryId
             * @param order
             * @param orderBy
             */
            var loadCollection = function (limit, page, categoryId, order, orderBy) {
                var params = {
                    limit: limit,
                    page: page,
                    categoryId: categoryId,
                    order: order,
                    orderBy: orderBy
                };

                itemService.getCollection(params).success(
                    function (data, status) {
                        $scope.collection = data;
                    }
                );
            };

            $scope.pageChanged = function (paginationPage) {
                $scope.paginationPage = paginationPage;

                loadCollection(
                    $scope.pageLimit,
                    paginationPage,
                    $scope.categoryId,
                    'id',
                    'ASC'
                );
            };

            $scope.pageChanged($scope.paginationPage);

        });
});

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

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            /**
             * Load page collection
             *
             * @param limit
             * @param page
             * @param categoryId
             * @param order
             * @param orderBy
             */
            var getPageCollection = function (limit, page, categoryId, order, orderBy) {
                var params = {
                    limit: limit,
                    page: page,
                    categoryId: categoryId,
                    order: order,
                    orderBy: orderBy
                };

                pageService.getPages(params).success(
                    function (data, status) {
                        $scope.collection = data;
                    }
                );
            };

            $scope.pageChanged = function (paginationPage) {
                getPageCollection(
                    $scope.pageLimit,
                    paginationPage,
                    $scope.categoryId,
                    'id',
                    'ASC'
                );
            };

            $scope.pageChanged($scope.paginationPage);


        }]);
});
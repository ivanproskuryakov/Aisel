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

            $scope.gridOptions = {
                enableRowSelection: true,
                enableSelectAll: true,
                selectionRowHeaderWidth: 35,
                rowHeight: 35,
                showGridFooter: true
            };

            $scope.gridOptions.columnDefs = [
                {name: 'id', width: '10%'},
                {name: 'locale', width: '15%'},
                {name: 'title'},
            ];

            $scope.pageLimit = 20;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            // Pages
            pageService.getPageList($scope).success(
                function (data, status) {
                    console.log(data);
                    $scope.pageList = data;
                    $scope.gridOptions.data = data.pages;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                pageService.getPageList($scope).success(
                    function (data, status) {
                        $scope.pageList = data;
                        $scope.gridOptions.data = data.pages;
                    }
                );
            };

        }]);
});
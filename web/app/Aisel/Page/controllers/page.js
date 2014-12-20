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
    app.controller('PageCtrl', ['$location', '$scope', '$stateParams', 'pageService',
        function ($location, $scope, $stateParams, pageService) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = 0;

            var handleSuccess = function (data, status) {
                $scope.pageList = data;
            };

            // Pages
            pageService.getPages($scope).success(
                function (data, status) {
                    $scope.pageList = data;
                }
            );

            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                pageService.getPages($scope).success(
                    function (data, status) {
                        $scope.pageList = data;
                    }
                );
            };

        }]);
});
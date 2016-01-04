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

define(['app'], function(app) {
    app.controller('PageCategoryDetailCtrl', ['$location', '$scope', '$stateParams', 'resourceService',
        function($location, $scope, $stateParams, resourceService) {

            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.categoryId = $stateParams.categoryId;

            var pageCategoryService = new resourceService('page/node');
            var pageService = new resourceService('page');

            // Category Information
            pageCategoryService.getItemByURL($scope.categoryId).success(
                function(data, status) {
                    $scope.category = data;
                }
            );

            // Pages
            pageService.getCollection($scope).success(
                function(data, status) {
                    $scope.pageList = data;
                }
            );
            $scope.pageChanged = function(page) {
                $scope.paginationPage = page;
                pageService.getCollection($scope).success(
                    function(data, status) {
                        $scope.pageList = data;
                    }
                );
            };
        }
    ]);
});

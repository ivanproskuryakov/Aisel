'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('PageCategoryCtrl', ['$location', '$scope', '$routeParams', 'pageCategoryService',
        function ($location, $scope, $routeParams, pageCategoryService) {
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                pageCategoryService.getCategories($scope).success(
                    function (data, status) {
                        $scope.pageCategoryList = data;
                    }
                );
            };

            // Categories
            pageCategoryService.getCategories($scope).success(
                function (data, status) {
                    $scope.pageCategoryList = data;
                }
            );
        }]);
});
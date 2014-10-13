'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.controller('CategoryCtrl', ['$location', '$scope', '$routeParams', 'categoryService',
        function ($location, $scope, $routeParams, categoryService) {
            $scope.pageLimit = 5;
            $scope.paginationPage = 1;
            $scope.pageChanged = function (page) {
                $scope.paginationPage = page;
                categoryService.getCategories($scope).success(
                    function (data, status) {
                        $scope.categoryList = data;
                    }
                );
            };

            // Categories
            categoryService.getCategories($scope).success(
                function (data, status) {
                    $scope.categoryList = data;
                }
            );
        }]);
});
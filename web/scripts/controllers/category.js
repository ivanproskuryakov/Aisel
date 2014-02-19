'use strict';

angular.module('projectxApp')
    .controller('CategoryCtrl', ['$location','$scope','$routeParams','categoryService',function ($location, $scope, $routeParams, categoryService) {

        $scope.pageLimit = 5;
        $scope.paginationPage = 1;


        $scope.pageChanged = function(page) {
            $scope.paginationPage = page;
            categoryService.getCategories($scope).success(
                function(data, status) {
                    $scope.categoryList = data;
                }
            );
        };

        // Categories
        categoryService.getCategories($scope).success(
            function(data, status) {
                $scope.categoryList = data;
            }
        );

        // CategoryTree
        categoryService.getCategoryTree($scope).success(
            function(data, status) {
                $scope.categoryTree = data;
            }
        );
//        $scope.categoryChanged = function(page) {
//            $scope.paginationPage = page;
//            categoryService.getCategories($scope).success(
//                function(data, status) {
//                    $scope.categoryList = data;
//                }
//            );
//        };

    }]);

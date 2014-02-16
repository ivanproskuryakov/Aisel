'use strict';

angular.module('projectxApp')
    .controller('MainCtrl', ['$location','$scope','$routeParams','navigationService','categoryService',function ($location, $scope, $routeParams, navigationService, categoryService) {

        // Category Tree
        categoryService.getCategoryTree($scope).success(
            function(data, status) {
                $scope.categoryTree = data;
            }
        );

        // Navigation Menu
        navigationService.getMenu().success(
            function(data, status) {
                $scope.navigationMenu = data;
            }
        );

    }]);
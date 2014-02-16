'use strict';

angular.module('projectxApp')
    .controller('CategoryDetailCtrl', ['$location','$scope','$routeParams','categoryService',function ($location, $scope, $routeParams, categoryService) {

        // Category Information
        var categoryId = $routeParams.categoryId;
        categoryService.getCategory(categoryId).success(
            function(data, status) {
                console.log(data);
                $scope.category = data;
            }
        );

    }]);
